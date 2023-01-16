<template>
	<div class="relative grid gap-4 sm:gap-6 lg:gap-8">
		<div class="flex h-12 absolute right-10 top-0">
			<Spinner v-if="role.saving" />
			<div class="mt-2 text-sm text-red-600" v-if="role.error">
				The employer information is not saved due to the following
				error:
				{{ role.error.response.data.message }}
			</div>
			<span class="mt-2 text-sm text-green-600" v-if="role.saved"
				>saved</span
			>
		</div>

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
		updateRole(role) {
			axios
				.post("/update_role", {
					role: role,
				})
				.then((r) => {
					console.log(r.data);
				})
				.catch((e) => {
					console.log(e);
					role.error = e;
				});
		},
	},
};
</script>

<style>
</style>
