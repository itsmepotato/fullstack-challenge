<template>
  <div>
    <div class="flex justify-center">
      <div class="min-h-screen flex overflow-x-scroll py-12">
        <div
          v-for="column in cardsByStages"
          :key="column.title"
          class="bg-gray-100 rounded-lg px-3 py-3 column-width rounded mr-4"
        >
          <div class="text-gray-700 font-semibold font-sans tracking-wide text-sm flex justify-between">
            {{column.name}} ({{column.cards_of_current_user.length}})
            <button @click="nuevaTareaModal(column)">
                + Nueva tarea
            </button>
          </div>
          <draggable :list="column.cards_of_current_user" :animation="200" ghost-class="ghost-card" group="cards_of_current_user"
           @change="onChange">
            <task-card
              v-for="(task) in column.cards_of_current_user"
              :key="task.id"
              :task="task"
              class="mt-3 cursor-move"
              @editarTareaModal="editarTareaModal"
            ></task-card>
            <!-- </transition-group> -->
          </draggable>
        </div>
      </div>

    </div>
    <CreateCardModal :isVisible="createModalOpen" :stageId="choosenColumnId" @closeModal="createModalOpen = false" @processed="processedStoreEvent"></CreateCardModal>
    <EditCardModal :isVisible="editModalOpen" :card="choosenTask" @closeModal="editModalOpen = false" @processed="processedUpdateEvent"></EditCardModal>
  </div>
</template>

<script>
import draggable from "vuedraggable";
import TaskCard from "../../components/TaskCard.vue";
import Swal from 'sweetalert2';
import CreateCardModal from "../../components/card/CreateCardModal.vue";
import EditCardModal from "../../components/card/EditCardModal.vue";
import {mapGetters} from 'vuex';

export default {
    name: "App",
    components: {
        TaskCard,
        draggable,
        CreateCardModal,
        EditCardModal
    },
    data: function () {
        return {
            createModalOpen: false,
            editModalOpen: false,
            choosenColumnId: null,
            choosenTask: null,
        };
    },
    methods: {
        nuevaTareaModal(column) {
            this.choosenColumnId = column.id;
            this.createModalOpen = !this.createModalOpen;
        },
        editarTareaModal(task) {
            // console.log('queres editar esta tarea?', task);
            this.choosenTask = task;
            this.editModalOpen = !this.editModalOpen;
        },
        onChange(event) {
            let element = event.added && event.added.element ? event.added.element : null;

            if (element) {
                for (let column of this.cardsByStages) {
                    let include = column.cards_of_current_user.includes(element);

                    if(include) {
                        // alert(`La card ${element.id} se movio a la columna ${column.name}`);
                        let oldStageId = element.stage_id;
                        element.stage_id = column.id;
                        this.$store.dispatch('updateCard', {cardForm: element, oldStageId});

                        if(column.id === "DONE") {
                            Swal.fire({
                                icon: 'success',
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                allowOutsideClick: false,
                                title: "Felicitaciones por lograrlo!",
                            })
                        }
                        break;
                    }
                }
            }
        },
        async processedStoreEvent(wasStoredInDoneColumn = false) {
            this.createModalOpen = false;
            // usamos async await para que se muestren los dos mensajes (uno despues otro)
            await Swal.fire({
                icon: 'success',
                allowEscapeKey: false,
                allowEnterKey: false,
                allowOutsideClick: false,
                title: "Tarjeta creada correctamente!",
            })
            if(wasStoredInDoneColumn) {
                this.showCongratulations();
            }
        },
        async processedUpdateEvent(wasStoredInDoneColumn = false) {
            this.editModalOpen = false;
            await Swal.fire({
                icon: 'success',
                allowEscapeKey: false,
                allowEnterKey: false,
                allowOutsideClick: false,
                title: "Tarjeta Actualizada correctamente!",
            });

            if(wasStoredInDoneColumn) {
                this.showCongratulations();
            }
        },
        showCongratulations() {
            Swal.fire({
                icon: 'success',
                allowEscapeKey: false,
                allowEnterKey: false,
                allowOutsideClick: false,
                title: "Felicitaciones por lograrlo!",
            });
        }
    },
    computed: {
        ...mapGetters(['cardsByStages']),
    },
    created() {
        this.$store.dispatch('getCardsByStages');
        this.$store.dispatch('getStages');
    }
};
</script>

<style scoped>
.column-width {
    min-width: 320px;
    width: 320px;
}

.ghost-card {
    @apply border opacity-50 border-blue-500 bg-gray-200
}
</style>

