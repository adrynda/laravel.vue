<template>
    <li
        class="group grid grid-cols-1 gap-3 md:grid-cols-1 rounded-xl border border-orange-200 p-2 hover:shadow-lg hover:bg-orange-100 transition-all duration-200"
    >
        <h3
            class="font-bold text-lg"
        >
            {{ localItem.title }} ({{ formatDate(localItem.dueDate) }})
            <div
                class="hidden float-right group-hover:inline-flex"
            >
                <a
                    data-class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded-l"
                    class="cursor-pointer bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded-l"
                    :href="'/todo/edit/' + localItem.id"
                >
                    Edycja
                </a>
                <button
                    data-class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded-r"
                    class="cursor-pointer bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded-r"
                    @click="remove"
                >
                    Usuń
                </button>
            </div>
        </h3>
        <p>
            {{ localItem.notes }}
        </p>
        <i>{{ localItem.category }}, {{ formatDate(localItem.createdAt) }}</i>
    </li>
</template>

<script>
    import axios from "axios";

    export default {
        name: 'Item',
        props: {
            item: {
                type: Object,
                required: true,
                validator(value) {
                    return (
                        typeof value.id === 'number' &&
                        typeof value.title === 'string' &&
                        typeof value.completed === 'boolean' &&
                        typeof value.createdAt === 'string' &&
                        typeof value.dueDate === 'string' &&
                        typeof value.priority === 'string' &&
                        typeof value.category === 'string' &&
                        typeof value.notes === 'string'
                    )
                }
            }
        },
        data() {
            return {
                localItem: { ...this.item }
            }
        },
        methods: {
            formatDate(dateString) {
                const date = new Date(dateString)
                const dd = String(date.getDate()).padStart(2, '0')
                const mm = String(date.getMonth() + 1).padStart(2, '0')
                const yyyy = date.getFullYear()
                const hh = String(date.getHours()).padStart(2, '0')
                const ii = String(date.getMinutes()).padStart(2, '0')
                return `${dd}.${mm}.${yyyy} ${hh}:${ii}`
            },
            remove() {
                axios
                    .delete('/api/to_dos/' + this.localItem.id)
                    .then((response)  => {
                        if (response.status === 204) {
                            this.$emit('remove', this.localItem.id);
                        }
                    })
                ;
            },
        }
    }
</script>
