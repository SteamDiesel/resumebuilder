<template>
	<div>
		<label
			:for="name"
			class="block text-sm font-medium text-gray-700 dark:text-gray-300"
			>{{ label }}</label
		>
		<div class="mt-1">
			<textarea
				:name="name"
				:id="name"
				class="
					block
                   
					w-full
					rounded-md

					border-gray-300
					shadow-sm
					focus:border-indigo-500 focus:ring-indigo-500
					sm:text-sm
					dark:text-gray-300 dark:bg-gray-800
				"
				:rows="rows"
				:placeholder="placeholder"
				:aria-describedby="label + '-description'"
				:value="value"
				@input="$emit('update:value', $event.target.value)"
			></textarea>
		</div>
		<p
			v-if="help"
			class="mt-2 text-sm text-gray-500"
			:id="label + '-description'"
		>
			{{ help }}
		</p>
		<p
			v-if="error"
			class="mt-2 text-sm text-red-600"
			:id="label + '-description'"
		>
			{{ error }}
		</p>
	</div>
</template>

<script>
export default {
	props: {
		label: String,
		name: String,
		help: String,
		rows: Number,
		error: String,
		value: String,
		placeholder: String,
	},
};
</script>

<style>
</style>
