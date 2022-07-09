export default {
	SET_USER(state, user) {
		state.user = user;
		state.isAuthenticated = Boolean(user);
	},
	SET_TOKEN(state, token) {
		state.token = token;
	}
};
