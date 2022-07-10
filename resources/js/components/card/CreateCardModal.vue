<template>
    <div v-if="isVisible">
        <div class="fixed inset-0 z-50 flex justify-center items-center">
            <div class="flex flex-col max-w-5xl rounded-lg shadow-lg bg-white">
                <!-- header-->
                <div class="p-5">
                    <div class="flex justify-between items-start">
                        <h3 class="text-2xl font-semibold">Agregar tarjeta</h3>
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
                            <label class="uppercase tracking-wide text-black text-xs font-bold mb-2" for="company">
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
                            <label class="uppercase tracking-wide text-black text-xs font-bold mb-2" for="company">
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
                </div>
                <!-- footer-->
                <div class="pb-6 pr-6 flex justify-end items-center">
                    <button class="btn-outline bg-red-500 hover:bg-red-600 text-white p-2" :disabled="isLoading" @click="emitCloseModal">Cancel</button>
                    <!-- <button class="btn ml-2 bg-blue-500 hover:bg-blue-600 text-white p-2" @click="emitConfirm">Agregar</button> -->
                    <button class="btn ml-2 bg-blue-500 hover:bg-blue-600 text-white p-2" :disabled="isLoading" @click="storeCard">Agregar</button>
                </div>
            </div>
        </div>
        <div class="opacity-25 fixed inset-0 z-40 bg-black"></div>
    </div>
</template>

<script>
    export default {
        name: 'CreateCardModal',
        props: {
            isVisible: {
                required: true
            },
            stageId: {
                required: true
            },
        },
        data: function () {
            return {
                isLoading: true,
                errors: null,
                cardForm: {
                    name: '',
                    delivery_date: '',
                    stage_id: null,
                },
            }
        },
        methods: {
            async storeCard() {
                this.isLoading = true
                this.errors = null;
                this.cardForm.stage_id = this.stageId;

                await this.$store.dispatch('storeCard', this.cardForm)
                .catch(err => {
                    this.isLoading = false;
                    this.errors = err.response.data.errors;
                });
                this.isLoading = false;

                this.clearCardForm();
                this.$emit('processed');
            },
            emitCloseModal() {
                this.$emit('closeModal');
            },
            clearCardForm() {
                this.cardForm = {
                    name: '',
                    delivery_date: '',
                    stage_id: null,
                };
            },
        }
    };
</script>

