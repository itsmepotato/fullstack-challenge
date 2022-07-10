import axios from "axios";
import http from "../../../http-common";

export default {
	async login({ dispatch, commit }, credentials) {
		let response = await axios.post('/api/login', credentials)
		commit("SET_TOKEN", response.data.token);
		return dispatch("getUser");
	},
	async getUser({ commit }) {
		try{
			let response = await http.get('/user')
			commit("SET_USER", response.data);
		}catch(error){
			commit("SET_USER", null);
		}
	},
	async logout({ dispatch, commit }) {
		commit("SET_TOKEN", null);
        commit("SET_CARDS_BY_STAGES", []);
        commit("SET_STAGES", []);
		await dispatch("getUser");
	}
};
