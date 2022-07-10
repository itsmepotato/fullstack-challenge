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
          <!-- Draggable component comes from vuedraggable. It provides drag & drop functionality -->
          <draggable :list="column.cards_of_current_user" :animation="200" ghost-class="ghost-card" group="cards_of_current_user"
           @change="onChange">
            <!-- Each element from here will be draggable and animated. Note :key is very important here to be unique both for draggable and animations to be smooth & consistent. -->
            <task-card
              v-for="(task) in column.cards_of_current_user"
              :key="task.id"
              :task="task"
              class="mt-3 cursor-move"
            ></task-card>
            <!-- </transition-group> -->
          </draggable>
        </div>
      </div>

    </div>
    <CreateCardModal :isVisible="createModalOpen" :stageId="choosenColumnId" @closeModal="createModalOpen = false" @processed="processedEvent"></CreateCardModal>
  </div>
</template>

<script>
import draggable from "vuedraggable";
import TaskCard from "../../components/TaskCard.vue";
import Swal from 'sweetalert2';
import CreateCardModal from "../../components/card/CreateCardModal.vue";
import {mapGetters} from 'vuex';

export default {
    name: "App",
    components: {
        TaskCard,
        draggable,
        CreateCardModal
    },
    data: function () {
        return {
            createModalOpen: false,
            choosenColumnId: null,
        };
    },
    methods: {
        nuevaTareaModal(column) {
            this.choosenColumnId = column.id;
            this.createModalOpen = !this.createModalOpen;
        },
        editarTareaModal(task) {
            console.log('queres editar esta tarea?', task);
        },
        onChange(event) {
            let element = event.added && event.added.element ? event.added.element : null;

            if (element) {
                for (let column of this.cardsByStages) {
                    let include = column.cards_of_current_user.includes(element);

                    if(include) {
                        // alert(`La card ${element.id} se movio a la columna ${column.name}`);
                        // dispatch update card, with arguments (element, column.id) == (card, stage_id)
                        // console.log(column.id);
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
        processedEvent() {
            this.createModalOpen = false;
            Swal.fire({
                icon: 'success',
                allowEscapeKey: false,
                allowEnterKey: false,
                allowOutsideClick: false,
                title: "Card creada correctamente!",
            })
        }
    },
    computed: {
        ...mapGetters(['cardsByStages']),
    },
    created() {
        this.$store.dispatch('getCardsByStages');
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

