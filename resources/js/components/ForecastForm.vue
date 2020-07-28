<template>
    <form @submit.prevent="onSubmit">

        <Alert v-if="error">{{ error }}</Alert>

        <div class="form-row">
            <div class="col-7">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Your city..."
                    v-model="city"
                    required
                >
            </div>
            <div class="col">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Country code..."
                    v-model="country"
                    required
                >
            </div>
        </div>

        <div class="form-row mt-2">
            <div class="col">
                <button type="submit" class="btn btn-primary">
                    Forecast
                </button>
            </div>
        </div>

    </form>
</template>

<script>
import Alert from './Alert';

export default {

    components: { Alert },

    data() {
        return {
            city: '',
            country: '',
            error: ''
        }
    },
    
    methods: {
        onSubmit() {
            this.error = '';
            try {
                this.require(this.city, 'City name is required.');
                this.require(this.country, 'Country code is required.');
                this.$emit('submit', this.city, this.country);
            } catch (e) {
                this.error = e.message;
            }
        },

        require(field, message) {
            if (field.trim().length == 0) {
                throw new Error(message);
            }
        }
    }
}
</script>