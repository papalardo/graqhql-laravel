/*=========================================================================================
  File Name: moduleAuthMutations.js
  Description: Auth Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuesax Admin - VueJS Dashboard Admin Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
	UPDATE_AUTHENTICATED_USER(state, user) {
		localStorage.setItem('userInfo', JSON.stringify(user));
		localStorage.setItem('userRole', 'admin');
  },
  UPDATE_TOKEN(state, { access_token, expires_in, token_type }) {
    const payload = { 
      access_token, 
      expires_in, 
      token_type 
    }
    state.token = payload
    localStorage.setItem('token', JSON.stringify(payload));
  }
}