<template>
    <v-dialog v-model="show" persistent width="300">
        <v-card color="primary" dark>
            <v-card-text>
                Please wait...
                <v-progress-linear indeterminate color="white" class="mb-0" />
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "ProgressBar",
    props: ['visible'],
    computed: {
        show: {
            get () {
                return this.visible
            },
            // set (value) {
            //     if (!value) {
            //         this.$emit('close')
            //     }
            // }
        }
    }
}
</script>



