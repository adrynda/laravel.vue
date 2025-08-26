<template>
    <li>
        <h3>
            {{ localItem.title }} ({{ formatDate(localItem.dueDate) }})
            <button @click="toggleComplete">{{ !localItem.completed ? 'Ukończ' : 'Przywróć' }}</button>
            <button @click="$emit('remove', localItem.id)">Usuń</button>
        </h3>
        <p>
            {{ localItem.notes }}
        </p>
        <i>{{ localItem.category }}, {{ formatDate(localItem.createdAt) }}</i>
    </li>
</template>

<script>
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
            toggleComplete() {
                this.localItem.completed = !this.localItem.completed
            }
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
            button {
                float: right;
                display: unset;
            }
        }
        button {
            display: none;
        }
    }
</style>
