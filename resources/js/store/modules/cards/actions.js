import axios from "axios";
import http from "../../../http-common";

export default {
	async getStagesWithCards({ commit }) {
		let response = await axios.get('/api/cards')
		commit("SET_STAGES_WITH_CARDS", response.data.token);
	},
	async storeCard({ dispatch }, cardForm) {
        // console.log(cardForm);
        await http.post('/cards', cardForm);
        await dispatch("getStagesWithCards");
	},
	async updateCard({ dispatch }, cardForm) {
        await http.put('/cards/' + cardForm.id, cardForm);
        await dispatch("getStagesWithCards");
	},
    // get specific card
};
