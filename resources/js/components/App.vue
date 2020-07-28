<template>
    <div class="container">
        
        <div class="text-center py-5">
            <h2>Get forecast</h2>
        </div>

        <div class="row">
            <div class="col-md-4">
                <Alert v-if="error">{{ error }}</Alert>
                <ForecastForm @submit="onSubmit"/>
                <Alert v-if="tempAvg && !error" type="success" class="mt-2">
                    Average temp: <b>{{ tempAvg }}</b>
                </Alert>
            </div>
        </div>

    </div>
</template>

<script>
import ForecastForm from './ForecastForm';
import Alert from './Alert';

export default {

    components: { ForecastForm, Alert },

    data() {
        return {
            tempAvg: '',
            error: ''
        }
    },

    methods: {
        async onSubmit(city, country) {
            this.error = '';
            this.tempAvg = '';
            try {
                const resp = await axios.get('/api/forecast', {
                    params: { city, country }
                });
                this.tempAvg = resp.data.temp;
            } catch (e) {
                this.error = 'Cannot get forecast data.';
            }
        }
    }
}
</script>