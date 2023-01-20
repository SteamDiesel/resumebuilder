<template>
	<div class="relative grid gap-4 sm:gap-6 lg:gap-8">
		<TextInput
			label="Role title"
			input_type="text"
			placeholder=""
			help="This is your job title"
			:value="role.title"
			@update:value="(newValue) => (role.title = newValue)"
			@change="updateRole(role)"
		/>
		<div class="sm:flex gap-4">
			<TextInput
				label="Start Date"
				input_type="date"
				:value="role.start"
				@update:value="(newValue) => (role.start = newValue)"
				@change="updateRole(role)"
			/>
			<TextInput
				label="End Date"
				input_type="date"
				:value="role.end"
				@update:value="(newValue) => (role.end = newValue)"
				@change="updateRole(role)"
			/>
            <div class="flex items-end">
                <button v-if="!deleting_wait" @click="deleteRole(role)" class="btn-warning ">
                    Delete
                </button>
                <div v-else class="btn-warning cursor-wait">
                    Delete
                </div>
            </div>
		</div>
        <div id="derp">
            <ParagraphArea>
                <Paragraph @keydown.enter="newParagraph(index)" @keydown.backspace="deleteParagraph(index)" v-for="(p, index) in role.paragraphs" :reference="'r'+role.id+'p'+index" :paragraph="p" :key="index"/>
            </ParagraphArea>
        </div>

		<!-- <Textarea
			label="Role Description"
			input_type="text"
			placeholder=""
			:rows="2"
			help="This is a description of the employer itself. Describe the industry and operations of the business."
			:value="role.description"
			@update:value="(newValue) => (role.description = newValue)"
			@change="updateRole(role)"
		/> -->
	</div>
</template>

<script>
import TextInput from "../Forms/TextInput.vue";
import Textarea from "../Forms/Textarea.vue";
import Spinner from "../Forms/Spinner.vue";
import { toast } from "vue3-toastify";
import ParagraphArea from '../Forms/ParagraphArea.vue';
import Paragraph from '../Components/Paragraph.vue';
import { nextTick } from '@vue/runtime-core';
import axios from 'axios';
export default {
	components: {
		TextInput,
		Textarea,
		Spinner,
        ParagraphArea,
        Paragraph,
	},
	props: {
		role: Object,
    },
    data() {
        return {
            deleting_wait: false
        }
    },
    methods: {
        deleteParagraph(index) {
            if (this.role.paragraphs[index].body == '') {
                let doomed = this.role.paragraphs.splice(index, 1)
                axios.post('/paragraph/'+ doomed[0].id +'/delete', {}).then(r => {
                    console.log('paragraph deleted')
                }).catch(e => {
                    console.log(e)
                    toast.error(e.message, { autoClose: 3000 })
                });
            }
        },
        async newParagraph(index) {
            let p = {
                user_id: null,
                role_id: this.role.id,
                body: ''
            }
            this.role.paragraphs.splice(index+1, 0, p)
            let id = 'r' + this.role.id + 'p' + (index + 1)
            console.log(id);
            await nextTick();
            document.getElementById(id).focus();
            axios.post('/paragraph/create', {
                paragraph:p
            }).then(r => {
                // console.log(r.data)
                this.role.paragraphs[index + 1].id = r.data.paragraph.id
                this.role.paragraphs[index + 1].user_id = r.data.paragraph.user_id
                console.log(this.role.paragraphs[index + 1])
            }).catch(e => {
                console.log(e)
            });

        },
        deleteRole(role) {
            this.deleting_wait = true;
            if (confirm('Are you sure you want to delete this role?')) {
                axios
				.post('/role/'+role.id+'/delete', {
					role: role,
				})
				.then((r) => {
					console.log(r.data);
					toast.success("Role Deleted", { autoClose: 1000 });
                    this.$emit("deleted");
				})
				.catch((e) => {
                    console.log(e);
					toast.error(e.message, { autoClose: 3000 });
                    this.deleting_wait = false;
				});
            };
            this.deleting_wait = false;
		},
		updateRole(role) {
			axios
				.post("/role/"+role.id+"/update", {
					role: role,
				})
				.then((r) => {
					console.log(r.data);
					toast.success("Role update Saved", { autoClose: 1000 });
				})
				.catch((e) => {
					console.log(e);
					role.error = e;
					toast.error(e.message, { autoClose: 3000 });
				});
		},
	},
};
</script>

<style>
</style>
