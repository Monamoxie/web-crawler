import Vue from 'vue'
import Vuex from 'vuex'


Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
    },
    getters: {
    },
    actions: {
        load (context, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/articles')
                .then(response => {
                    resolve(response)
                })
                .catch(errors => {
                    reject(errors)
                })
            })
        }
    },
    mutations: {
    },
    
})