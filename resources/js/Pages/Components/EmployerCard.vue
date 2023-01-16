<template>
	<div
		class="
			border
			p-4
			sm:p-6
			lg:p-8
			rounded
			relative
			grid
			gap-4
			sm:gap-6
			lg:gap-8
		"
	>
		<TextInput
			label="Employer Name"
			input_type="text"
			placeholder=""
			help="This is the employer name that will appear on your resume"
			:value="emp.name"
			@update:value="(newValue) => (emp.name = newValue)"
			@change="updateEmployer(emp)"
		/>
		<Textarea
			label="Employer Description"
			input_type="text"
			placeholder=""
			:rows="2"
			help="This is a description of the employer itself. Describe the industry and operations of the business."
			:value="emp.description"
			@update:value="(newValue) => (emp.description = newValue)"
			@change="updateEmployer(emp)"
		/>
		<RoleCard
			v-for="(role, index) in emp.roles"
			:key="index"
			:role="role"
			@deleted="dropRole(index)"
		/>
		<div class="flex w-full justify-start pl-4">
			<button
				v-if="!role_loading"
				@click.prevent="createRole"
				class="btn-primary"
			>
				Add Role
			</button>
			<div v-else class="btn-primary cursor-wait">Add Role</div>
		</div>
	</div>
</template>

<script>
import TextInput from "../Forms/TextInput.vue";
import Textarea from "../Forms/Textarea.vue";

import RoleCard from "./RoleCard.vue";
import { toast } from "vue3-toastify";

export default {
	components: {
		TextInput,
		Textarea,
		RoleCard,
	},
	props: {
		emp: Object,
	},
	data() {
		return {
			role_loading: false,
		};
	},
	methods: {
		dropRole(ind) {
			this.emp.roles.splice(ind, 1);
		},
		createRole() {
			let id = this.emp.id;
			console.log(id);
			this.role_loading = true;
			axios
				.post("/create_role", {
					id: id,
				})
				.then((r) => {
					console.log(r.data);
					this.emp.roles.push(r.data.role);
					toast.success("Role Created", { autoClose: 1000 });
					this.role_loading = false;
				})
				.catch((e) => {
					console.log(e);
					toast.error(e.message, { autoClose: 3000 });
					this.role_loading = false;
				});
		},
		updateEmployer(emp) {
			axios
				.post("/update_employer", {
					emp: emp,
					name: emp.name,
					description: emp.description,
				})
				.then((r) => {
					console.log(r.data);
					if (emp.error) {
						emp.error = null;
					}
					toast.success("Role Created Saved", { autoClose: 1000 });
				})
				.catch((e) => {
					console.log(e);
					toast.error(e.message, { autoClose: 3000 });
				});
		},
	},
};
</script>

<style>
</style>
