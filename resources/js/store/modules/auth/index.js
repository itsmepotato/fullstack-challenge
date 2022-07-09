import mutations from './mutations'
import actions from './actions'
import getters from './getters'

export default {
	state() {
		return {
			user: null,
			token: null,
			isAuthenticated: false,
		};
	},
	mutations,
	getters,
	actions,
}
