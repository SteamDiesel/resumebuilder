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
		<div class="flex h-12 absolute right-10 top-0">
			<Spinner v-if="emp.saving" />
			<div class="mt-2 text-sm text-red-600" v-if="emp.error">
				The employer information is not saved due to the following
				error:
				{{ emp.error.response.data.message }}
			</div>
			<span class="mt-2 text-sm text-green-600" v-if="emp.saved"
				>saved</span
			>
		</div>

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
		/>
	</div>
</template>

<script>
import TextInput from "../Forms/TextInput.vue";
import Textarea from "../Forms/Textarea.vue";
import Spinner from "../Forms/Spinner.vue";
import RoleCard from "./RoleCard.vue";

export default {
	components: {
		TextInput,
		Textarea,
		Spinner,
		RoleCard,
	},
	props: {
		emp: Object,
	},
	methods: {
		updateEmployer(emp) {
			emp.saving = true;
			emp.saved = false;
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
					emp.saving = false;
					emp.saved = true;
				})
				.catch((e) => {
					console.log(e);
					emp.error = e;
					emp.saving = false;
				});
		},
	},
};
</script>

<style>
</style>
