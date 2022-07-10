<template>
    <div v-if="isVisible">
        <div class="fixed inset-0 z-50 flex justify-center items-center">
            <div class="flex flex-col max-w-5xl rounded-lg shadow-lg bg-white">
                <!-- header-->
                <div class="p-5">
                    <div class="flex justify-between items-start">
                        <h3 class="text-2xl font-semibold">Editar tarjeta</h3>
                        <button class="p-1 leading-none" @click="emitCloseModal" :disabled="isLoading">
                            <div class="text-xl font-semibold h-6 w-6"><span>x</span></div>
                        </button>
                    </div>
                </div>
                <!-- body-->
                <div class="p-6">
                    <div v-if="errors" class="mb-2">
                    <!-- <div class="mb-2"> -->
						<span class="text-red-500 text-xl italic">
							Hay algunos errores!
						</span>
					</div>
                    <div class="-mx-3 md:flex mb-6">
                        <div class="md:w-full px-3 mb-6 md:mb-0">
                            <label class="uppercase tracking-wide text-black text-xs font-bold mb-2">
                            Nombre
                            </label>

                            <input  v-model="cardForm.name" :disabled="isLoading" class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3" type="text" placeholder="Nombre"/>

                            <div>
                                <span class="text-red-500 text-xs italic">
                                  {{ errors && errors.name ? errors.name[0] : '' }}
                                </span>
                            </div>
                        </div>
					</div>

                    <div class="-mx-3 md:flex mb-6">
						<div class="md:w-full px-3">
                            <label class="uppercase tracking-wide text-black text-xs font-bold mb-2">
                                Fecha de entrega
                            </label>

                            <input  v-model="cardForm.delivery_date" :disabled="isLoading" class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3" type="date" placeholder="Fecha de entrega"/>

                            <div>
                                <span class="text-red-500 text-xs italic">
                                  {{ errors && errors.delivery_date ? errors.delivery_date[0] : '' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="-mx-3 md:flex mb-6">
						<div class="md:w-full px-3">
                            <label class="uppercase tracking-wide text-black text-xs font-bold mb-2">
                                Columna
                            </label>

                            <select v-model="cardForm.stage_id" class="w-full px-4 py-3 mb-3 text-black bg-gray-200 border border-gray-200 rounded">
                                <option disabled value="">Favor elegir una columna</option>
                                <option v-for="stage in stages" :value="stage.id" :key="stage.id">{{stage.name}}</option>
                            </select>

                            <div>
                                <span class="text-red-500 text-xs italic">
                                  {{ errors && errors.delivery_date ? errors.delivery_date[0] : '' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer-->
                <div class="pb-6 pr-6 flex justify-end items-center">
                    <button class="btn-outline bg-red-500 hover:bg-red-600 text-white p-2" :disabled="isLoading" @click="emitCloseModal">Cancel</button>
                    <!-- <button class="btn ml-2 bg-blue-500 hover:bg-blue-600 text-white p-2" @click="emitConfirm">Agregar</button> -->
                    <button class="btn ml-2 bg-blue-500 hover:bg-blue-600 text-white p-2" :disabled="isLoading" @click="updateCard">Actualizar</button>
                </div>
            </div>
        </div>
        <div class="opacity-25 fixed inset-0 z-40 bg-black"></div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    export default {
        name: 'EditCardModal',
        props: {
            isVisible: {
                required: true
            },
            card: {
                required: true
            },
        },
        data: function () {
            return {
                isLoading: false,
                errors: null,
                cardForm: {
                    id: '',
                    name: '',
                    delivery_date: '',
                    stage_id: null,
                },
            }
        },
        computed: {
            ...mapGetters(['stages']),
        },
        watch: {
            card: function (cardData) {
                this.fillCardForm();
            },
            isVisible: function (isVisible) {
                if (isVisible) {
                    this.errors = null;
                    this.fillCardForm();
                }
            },
        },
        methods: {
            async updateCard() {
                this.isLoading = true
                this.errors = null;

                let oldStageId = this.card.stage_id;
                await this.$store.dispatch('updateCard', {cardForm: this.cardForm, oldStageId})
                .then(() => {
                    this.isLoading = false;

                    let mustShowCongratulations = false;

                    if(this.cardForm.stage_id === "DONE") {
                        mustShowCongratulations = true;
                    }

                    this.$emit('processed', mustShowCongratulations);
                })
                .catch(err => {
                    this.isLoading = false;
                    this.errors = err.response.data.errors;
                    return;
                });
            },
            emitCloseModal() {
                this.$emit('closeModal');
            },
            fillCardForm() {
                this.cardForm = {
                    id: this.card.id,
                    name: this.card.name,
                    delivery_date: this.card.delivery_date,
                    stage_id: this.card.stage_id,
                };
            }
        },
    };
</script>

