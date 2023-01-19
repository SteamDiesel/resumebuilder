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
        <div class=" flex flex-col sm:flex-row gap-4">

        <TextInput
				label="Start Date"
				input_type="date"
				:value="emp.start"
				@update:value="(newValue) => (emp.start = newValue)"
				@change="updateEmployer(emp)"
			/>
			<TextInput
				label="End Date"
				input_type="date"
				:value="emp.end"
				@update:value="(newValue) => (emp.end = newValue)"
				@change="updateEmployer(emp)"
			/>
			<Checkbox
				label="Current Employer"
				:value="emp.current"
				@update:value="(newValue) => (emp.current = newValue) + updateEmployer(emp)"

			/>

			<div class="flex items-end">
                <button v-if="!deleting_wait" @click="deleteEmployer(emp)" class="btn-warning ">
                    Delete
                </button>
                <div v-else class="btn-warning cursor-wait">
                    Delete
                </div>
            </div>

        </div>
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
        <div class="pl-4
			sm:pl-6
			lg:pl-8">

		<RoleCard
			v-for="(role, index) in emp.roles"
			:key="index"
			:role="role"
			@deleted="dropRole(index)"
		/>
		<div class="flex w-full justify-start pt-4 ">
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
	</div>
</template>

<script>
import TextInput from "../Forms/TextInput.vue";
import Textarea from "../Forms/Textarea.vue";

import RoleCard from "./RoleCard.vue";
import { toast } from "vue3-toastify";
import Checkbox from "../Forms/Checkbox.vue";

export default {
	components: {
    TextInput,
    Textarea,
    RoleCard,
    Checkbox
},
	props: {
		emp: Object,
	},
	data() {
		return {
            role_loading: false,
            deleting_wait: false
		};
	},
    methods: {
        deleteEmployer(emp) {
            if (confirm('Are you sure you want to delete this employer?')) {
                this.deleting_wait = true;
                axios
                    .post("/employer/" + emp.id + "/delete", {})
				.then((r) => {
					console.log(r.data);
					toast.success("Employer Deleted", { autoClose: 1000 });
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
					toast.success("Employer update saved", { autoClose: 1000 });
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
