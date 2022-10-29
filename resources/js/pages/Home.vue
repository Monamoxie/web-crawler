<template>
    <div class="justify-content-center mt-5">
        <div class="lds-ring" v-if="loading"><div></div><div></div><div></div><div></div></div>
        <div class="row articles" v-else>
            <div class="col-md-5 mb-4 mr-4 ml-4" v-for="(result, index) in results" :key="index" >
                <div class="article row">
                   <div>
                        <a :href="result.title_link" target="_blank"><img :src="result.image_url" :alt="result.title"/></a>
                        <h4> {{ result.title }} </h4>
                        <quote class="d-block">{{ result.excerpt }}</quote>
                        <div class="date">{{ result.date }}</div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Home',
    data() {
        return {
            results: [],
            errors: [],
            loading: true
        }
    },  
    methods: {
        load() {
            this.$store.dispatch('load')
            .then((response) => {     
                this.results = response.data
            })  
            .catch(error => { 
                if (error.response.data.errors !== null && error.response.data.errors !== undefined) {
                    this.errors = typeof error.response.data.errors === 'object' ? Object.values(error.response.data.errors) : [{0: error.response.data.errors }]
                }
            })
            .finally(() => {
                this.loading = false  
            })
        }
    },
    mounted() {
        this.load()
    }
}
</script>