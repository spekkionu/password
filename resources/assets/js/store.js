export default {
    state: {
        sites: [],
        site: {}
    },
    getters: {
        sites: state => {
            return state.sites;
        },
        site: state => {
            return state.site;
        },
    },
    mutations: {
        refreshSites(state, sites) {
            state.sites = sites;
        },
        refreshSite(state, site) {
            state.site = site;
        }
    },
    actions: {
        loadSites({commit}) {
            return window.axios({
                method: 'get',
                url: '/site'
            }).then(function (response) {
                commit('refreshSites', response.data);
            }).catch((error) => {
                // user is not logged in
            });
        },
        addSite({commit}, params) {
            return window.axios({
                method: 'post',
                url: '/site',
                data: params
            }).then(function (response) {
                return response.data;
            }).catch((error) => {
                // user is not logged in
            });
        },
        loadSite({commit}, id) {
            return window.axios({
                method: 'get',
                url: '/site/' + id
            }).then(function (response) {
                commit('refreshSite', response.data);
            }).catch((error) => {
                // user is not logged in
            });
        },
        updateSite({dispatch}, params) {
            return window.axios({
                method: 'patch',
                url: '/site/' + params.id,
                data: params
            }).then(function (response) {
                dispatch('loadSite', params.id);
            }).catch((error) => {
                // user is not logged in
            });
        },
        deleteSite({commit}, id) {
            return window.axios({
                method: 'delete',
                url: '/site/' + id
            }).then(function (response) {
                return response.data;
            }).catch((error) => {
                // user is not logged in
            });
        },
        addSection({dispatch}, {id, name}) {
            return window.axios({
                method: 'post',
                url: '/site/' + id + '/section',
                data: {name}
            }).then(function (response) {
                dispatch('loadSite', id);
            }).catch((error) => {
                // user is not logged in
            });
        },
        updateSection({dispatch}, {site, section, name}) {
            return window.axios({
                method: 'patch',
                url: '/site/' + site + '/section/' + section,
                data: {name}
            }).then(function (response) {
                dispatch('loadSite', site);
            }).catch((error) => {
                // user is not logged in
            });
        },
        deleteSection({dispatch}, {site, section}) {
            return window.axios({
                method: 'delete',
                url: '/site/' + site + '/section/' + section
            }).then(function (response) {
                dispatch('loadSite', site);
            }).catch((error) => {
                // user is not logged in
            });
        },
        addData({dispatch}, {site, section, name, data}) {
            return window.axios({
                method: 'post',
                url: '/site/' + site + '/section/' + section + '/data',
                data: {name, data}
            }).then(function (response) {
                dispatch('loadSite', site);
            }).catch((error) => {
                // user is not logged in
            });
        },
        updateData({dispatch}, {site, section, id, name, data}) {
            return window.axios({
                method: 'patch',
                url: '/site/' + site + '/section/' + section + '/data/' + id,
                data: {name, data}
            }).then(function (response) {
                dispatch('loadSite', site);
            }).catch((error) => {
                // user is not logged in
            });
        },
        deleteData({dispatch}, {site, section, id}) {
            return window.axios({
                method: 'delete',
                url: '/site/' + site + '/section/' + section + '/data/' + id,
            }).then(function (response) {
                dispatch('loadSite', site);
            }).catch((error) => {
                // user is not logged in
            });
        },
    }
}
