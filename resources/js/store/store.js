import VuexPersistence from 'vuex-persist';
import auth from './modules/auth/index';
import cards from './modules/cards/index';
import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex);

const store = new Vuex.Store({
	modules: {
		auth,
        cards
	},
	plugins: [
		new VuexPersistence({
			key: 'auth',
			storage: window.localStorage
		}).plugin
	]
});

export default store;
