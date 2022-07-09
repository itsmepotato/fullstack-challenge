<template>
  <div id="app">
    <div class="flex justify-center">
      <div class="min-h-screen flex overflow-x-scroll py-12">
        <div
          v-for="column in columns"
          :key="column.title"
          class="bg-gray-100 rounded-lg px-3 py-3 column-width rounded mr-4"
        >
          <div class="text-gray-700 font-semibold font-sans tracking-wide text-sm flex justify-between">
            {{column.name}} ({{column.cards.length}})
            <button @click="nuevaTareaModal()">
                + Nueva tarea
            </button>
          </div>
          <!-- Draggable component comes from vuedraggable. It provides drag & drop functionality -->
          <draggable :list="column.cards" :animation="200" ghost-class="ghost-card" group="cards"
           @change="onChange">
            <!-- Each element from here will be draggable and animated. Note :key is very important here to be unique both for draggable and animations to be smooth & consistent. -->
            <task-card
              v-for="(task) in column.cards"
              :key="task.id"
              :task="task"
              class="mt-3 cursor-move"
            ></task-card>
            <!-- </transition-group> -->
          </draggable>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import draggable from "vuedraggable";
import TaskCard from "../../components/TaskCard.vue";
import Swal from 'sweetalert2';

export default {
  name: "App",
  components: {
    TaskCard,
    draggable
  },
  data: function () {
    return {
      columns: [
        {
            id: "BUFFER",
            name: "Buffer",
            order: 1,
            cards: [
                {
                    id: 1,
                    name: "Add discount code to checkout page",
                    user_id: "1",
                    stage_id: "BUFFER",
                    delivery_date: "2022-07-15",
                    delivered_at: null,
                },
                {
                    id: 2,
                    name: "Add discount",
                    user_id: "1",
                    stage_id: "BUFFER",
                    delivery_date: "2022-07-15",
                    delivered_at: null,
                },
                {
                    id: 3,
                    name: "Checkout page",
                    user_id: "1",
                    stage_id: "BUFFER",
                    delivery_date: "2022-07-15",
                    delivered_at: null,
                },
                {
                    id: 4,
                    name: "Checkout page",
                    user_id: "1",
                    stage_id: "BUFFER",
                    delivery_date: "2022-07-15",
                    delivered_at: null,
                },


            ]
        },
        {
            id: "WORKING",
            name: "Working",
            order: 2,
            cards: [
                {
                    id: 5,
                    name: "Add discount code to checkout page",
                    user_id: "1",
                    stage_id: "WORKING",
                    delivery_date: "2022-07-10",
                    delivered_at: null,
                },
                {
                    id: 6,
                    name: "Add discount",
                    user_id: "1",
                    stage_id: "WORKING",
                    delivery_date: "2022-07-11",
                    delivered_at: null,
                },
            ]
        },
        {
            id: "DONE",
            name: "Done",
            order: 3,
            cards: [
                {
                    id: 7,
                    name: "Checkout page",
                    user_id: "1",
                    stage_id: "DONE",
                    delivery_date: "2022-07-09",
                    delivered_at: null,
                },
                {
                    id: 8,
                    name: "Page",
                    user_id: "1",
                    stage_id: "DONE",
                    delivery_date: "2022-07-13",
                    delivered_at: null,
                },
            ]
        },
      ]
    };
  },
  methods: {
    nuevaTareaModal() {
        Swal.fire({
            icon: 'success',
            allowEscapeKey: false,
            allowEnterKey: false,
            allowOutsideClick: false,
            title: "Felicitaciones por lograrlo!",
        })
    },
    editarTareaModal(task) {
        console.log('queres editar esta tarea?', task);
    },
    onChange(event) {
        let element = event.added && event.added.element ? event.added.element : null;

        if (element) {
            for (let column of this.columns) {
                let include = column.cards.includes(element);

                if(include) {
                    // alert(`La card ${element.id} se movio a la columna ${column.name}`);
                    // dispatch update card, with arguments (element, column.id) == (card, stage_id)
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

                // console.log(column.title);
            }
        }
    },
  }
};
</script>

<style scoped>
.column-width {
  min-width: 320px;
  width: 320px;
}
/* Unfortunately @apply cannot be setup in codesandbox,
but you'd use "@apply border opacity-50 border-blue-500 bg-gray-200" here */
.ghost-card {
  opacity: 0.5;
  background: #F7FAFC;
  border: 1px solid #4299e1;
}
</style>

