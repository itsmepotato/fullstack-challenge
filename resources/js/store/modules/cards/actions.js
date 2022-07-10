import http from "../../../http-common";

export default {
	async getCardsByStages({ commit }) {
		let response = await http.get('/get-cards-by-stages')
        // console.log(response.data);
		commit("SET_CARDS_BY_STAGES", response.data);
	},
	async storeCard({ dispatch }, cardForm) {
        // console.log(cardForm);
        await http.post('/cards', cardForm);
        await dispatch("getCardsByStages");
	},
	async updateCard({ dispatch }, cardForm) {
        await http.put('/cards/' + cardForm.id, cardForm);
        await dispatch("getCardsByStages");
	},
    // get specific card
};
