<template>
    <div class="alert" :class="alertType">
        <slot></slot>
    </div>
</template>

<script>
export default {

    props: {
        type: {
            type: String,
            default: 'danger'
        }
    },

    computed: {
        alertType() {
            return [`alert-${this.type}`];
        }
    }
}
</script>