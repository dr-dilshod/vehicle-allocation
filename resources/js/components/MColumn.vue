<template>
    <div class="m-column">
        <div v-if="this.$parent.mode == 'normal'">
            {{value}}
        </div>
        <input type="text" :value="value" :name="name" v-if="this.$parent.mode == 'edit' && this.type == 'text'" style="width: 100%; padding: 0.25rem 0.75rem">
        <input type="checkbox" :value="value" :name="name" v-if="this.$parent.mode == 'edit' && this.type == 'checkbox'" style="width: 100%; padding: 0.25rem 0.75rem">
    </div>
</template>
<script>
    export default{
        name: "MColumn",
        props:{
            name: {type:String, required: true},
            type: {type:String},
            value: {type: [String,Number,Date,JSON,Array,Object]},
        },
        data(){
            return {

            };
        },
        mounted(){

        },
        methods: {

        }
    }
</script>
<style>

</style>