import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersistence from 'vuex-persist';

import auth from './modules/auth/index';
import cards from './modules/cards/index';
import stages from './modules/stages/index';


Vue.use(Vuex);

const store = new Vuex.Store({
	modules: {
		auth,
        cards,
        stages
	},
	plugins: [
		new VuexPersistence({
			key: 'kanban-app',
			storage: window.localStorage
		}).plugin
	]
});

export default store;
