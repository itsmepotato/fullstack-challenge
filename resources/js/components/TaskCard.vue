<template>
  <div class="bg-white shadow rounded px-3 pt-3 pb-5 border border-white">
    <div class="flex justify-between">
      <p class="text-gray-700 font-semibold font-sans tracking-wide text-sm">{{task.name}}</p>

    <button @click="editarTarea">
        <img
            class="w-6 h-6 rounded-full ml-3"
            src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/64/Edit_icon_%28the_Noun_Project_30184%29.svg/1024px-Edit_icon_%28the_Noun_Project_30184%29.svg.png"
            alt="Editar"
        >
    </button>

    </div>
    <div class="flex mt-4 justify-between items-center">
      <span class="text-sm text-gray-600">{{task.delivery_date}}</span>
    </div>
    <h1 class="text-red-400" v-if="isOverdue">overdue</h1>
    <h1 class="text-green-400" v-if="isCompletedInTime">In time</h1>
    <h1 class="text-red-400" v-if="isCompletedLate">Complete late</h1>
  </div>
</template>
<script>
export default {
  components: {
  },
  props: {
    task: {
      type: Object,
      default: () => ({})
    }
  },
  computed: {
    isOverdue() {
        return this.task.delivered_at === null & this.task.delivery_date < new Date().toISOString().split('T')[0];
    },
    isCompletedInTime() {
        return this.task.delivered_at !== null && this.task.delivered_at <= this.task.delivery_date;
    },
    isCompletedLate() {
        return this.task.delivered_at !== null && this.task.delivered_at > this.task.delivery_date;
    }
  },
  methods: {
    editarTarea() {
        // alert('llamar al modal para editar la tarea');
        this.$emit('editarTareaModal', this.task);
    },
  }
};
</script>

