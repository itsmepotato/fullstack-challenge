<template>
  <div class="bg-white shadow rounded px-3 pt-3 pb-5 border border-white">
    <div class="flex justify-between">
        <div>
            <p class="text-gray-700 font-semibold font-sans tracking-wide text-sm" v-bind:class="{ 'text-red-500': isOverdue }">{{task.name}}</p>
            <badge class="my-1" :color="badgeColor">{{badgeText}}</badge>
        </div>

        <button class="flex flex-start" @click="editarTarea">
            <img
                class="w-6 h-6 rounded-full ml-3"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/64/Edit_icon_%28the_Noun_Project_30184%29.svg/1024px-Edit_icon_%28the_Noun_Project_30184%29.svg.png"
                alt="Editar"
            >
        </button>
    </div>
    <div class="flex mt-4 justify-between items-center">
      <span class="text-sm text-gray-600" v-bind:class="{ 'text-red-500': isOverdue }">Fecha limite: {{deliveryDateFormatted}}</span>
    </div>
    <div class="flex justify-between items-center">
      <span class="text-sm text-gray-600" v-bind:class="{ 'text-red-500': isOverdue }">Fecha entregado: {{deliveredDateFormatted}}</span>
    </div>
  </div>
</template>
<script>
import dayjs from 'dayjs';
import Badge from "./Badge.vue";
export default {
  components: {
    Badge
  },
  props: {
    task: {
      type: Object,
      default: () => ({})
    }
  },
  data: function () {
    return {
        currertDate: new Date().toISOString().split('T')[0]
    };
  },
  computed: {
    isOverdue() {
        return !this.isCompleted && this.task.delivery_date < this.currertDate;
    },
    isInTime() {
        return !this.isCompleted && this.task.delivery_date >= this.currertDate;
    },
    isCompletedInTime() {
        return this.isCompleted && this.task.delivered_at <= this.task.delivery_date;
    },
    isCompletedLate() {
        return this.isCompleted && this.task.delivered_at > this.task.delivery_date;
    },
    isCompleted() {
        return this.task.delivered_at !== null;
    },
    deliveryDateFormatted() {
        return dayjs(this.task.delivery_date).format('DD/MM/YYYY')
    },
    deliveredDateFormatted() {
        if(this.task.delivered_at === null) {
            return '-';
        }
        return dayjs(this.task.delivered_at).format('DD/MM/YYYY')
    },
    badgeColor() {
        if(this.isOverdue) {
            return 'red';
        }
        if(this.isCompletedInTime) {
            return 'green';
        }
        if(this.isInTime) {
            return 'green';
        }
        if(this.isCompletedLate) {
            return 'red';
        }
    },
    badgeText() {
        if(this.isOverdue) {
            return 'Atrasado';
        }
        if(this.isCompletedInTime) {
            return 'Completado en tiempo';
        }
        if(this.isInTime) {
            return 'En tiempo';
        }
        if(this.isCompletedLate) {
            return 'Completado tarde';
        }
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

