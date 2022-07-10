import http from "../../../http-common";

export default {
	async getStages({ commit }) {
		let response = await http.get('/stages')
		commit("SET_STAGES", response.data);
	},
};
