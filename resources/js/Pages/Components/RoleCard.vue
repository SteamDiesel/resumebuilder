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
			<button @click="deleteRole(role)" class="btn-primary">
				Delete
			</button>
		</div>

		<Textarea
			label="Role Description"
			input_type="text"
			placeholder=""
			:rows="2"
			help="This is a description of the employer itself. Describe the industry and operations of the business."
			:value="role.description"
			@update:value="(newValue) => (role.description = newValue)"
			@change="updateRole(role)"
		/>
	</div>
</template>

<script>
import TextInput from "../Forms/TextInput.vue";
import Textarea from "../Forms/Textarea.vue";
import Spinner from "../Forms/Spinner.vue";
import { toast } from "vue3-toastify";
export default {
	components: {
		TextInput,
		Textarea,
		Spinner,
	},
	props: {
		role: Object,
	},
	methods: {
		deleteRole(role) {
			axios
				.post("/delete_role", {
					role: role,
				})
				.then((r) => {
					console.log(r.data);
					toast.success("Role Deleted", { autoClose: 1000 });
					this.$emit("deleted");
				})
				.catch((e) => {
					console.log(e);
					role.error = e;
					toast.error(e.message, { autoClose: 3000 });
				});
		},
		updateRole(role) {
			axios
				.post("/update_role", {
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
