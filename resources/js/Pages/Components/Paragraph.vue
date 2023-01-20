<template>
  <input :id="reference" v-model="paragraph.body" @change="save" type="text" class="w-full bg-inherit text-inherit p-2">
</template>

<script>
import axios from 'axios'
export default {
    props: {
        paragraph: Object,
        reference: String
    },
    methods: {
        save() {
            axios.post('/paragraph/'+ this.paragraph.id +'/update', {
                body: this.paragraph.body
            }).then(r => {
                console.log(r.data)
            }).catch(e => {
                console.log(e)
            });
        }
    }
}
</script>

