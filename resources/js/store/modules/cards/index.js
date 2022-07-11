import mutations from './mutations'
import actions from './actions'
import getters from './getters'

export default {
	state() {
		return {
			cardsByStages: [],
		};
	},
	mutations,
	getters,
	actions,
}
