<template>
    <div @mouseover="show_btn = true" @mouseleave="show_btn = false">
        <img :src="image_path" class="img-thumbnail"/>
        <v-btn v-show="show_btn" error @click.native="deleteImage">Delete</v-btn>
        <v-btn v-show="show_btn" primary @click.native="selectImage">Select</v-btn>
    </div>
</template>
<script>
    export default {
        props: ['imgid'],
        mounted() {
            this.id = this.imgid;
            this.image_path = '/images/' + this.imgid;
        },
        data: function () {
            return {
                id: null,
                image_path: null,
                show_btn: false
            }
        },
        methods: {
            deleteImage() {
                axios.delete('/webapi/images/' + this.id).then(function(response){
                    console.log('Image ' + this.id + ' deleted');
                    this.$emit('deleted', this.id);
                }.bind(this));
            },
            selectImage() {
                this.$emit('selected', this.id);
            }
        }
    }
</script>
