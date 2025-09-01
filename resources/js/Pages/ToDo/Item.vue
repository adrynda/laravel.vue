<template>
    <li>
        <h3>
            {{ localItem.title }} ({{ formatDate(localItem.dueDate) }})
            <a :href="'/todo/edit/' + localItem.id">Edycja</a>
            <button @click="remove">Usuń</button>
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

<style scoped>
    li {
        border: 1px solid #ddd;
        padding: 5px;
        margin: 5px;
        &:hover {
            background-color: #ddd;
            a, button {
                float: right;
                display: unset;
            }
        }
        a, button {
            display: none;
        }
    }
</style>
