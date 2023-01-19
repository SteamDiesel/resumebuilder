<template>
	<div>
		<label
			:for="name"
			class="block text-sm font-medium text-gray-700 dark:text-gray-300"
			>{{ label }}</label
		>
		<div class="mt-3 mx-2 flex items-end">
			<button
				type="checkbox"
				:name="name"
				:id="name"
                :class="[value ? 'bg-indigo-600': 'bg-gray-200',
                'h-6 w-6 block rounded-md text-gray-200 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500  ']"
				@click="toggle"
			>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="1.5em" height="1.5em"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            </button>

		</div>

	</div>
</template>

<script>

export default {

	props: {
		label: String,
		name: String,
		help: String,
		error: String,
		value: Boolean,
    },
    methods: {
        toggle() {
            console.log(!this.value)
            this.$emit('update:value', !this.value)
        }
    }

};
</script>

<style>
</style>
