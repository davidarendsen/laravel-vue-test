<template>
    <div>
        <h1>My Tasks</h1>
        <h4>New Task</h4>
        <form action="#" @submit.prevent="edit ? updateTask(task.id) : createTask()">
            <div class="input-group">
                <input v-model="task.body" v-el:taskinput type="text" name="body" class="form-control" autofocus>
                <span class="input-group-btn">
                    <button v-show="!edit" type="submit" class="btn btn-primary">New Task</button>
                    <button v-show="edit" type="submit" class="btn btn-primary">Edit Task</button>
                </span>
            </div>
        </form>
        <h4>All Tasks</h4>
        <ul class="list-group">
            <li class="list-group-item" v-for="task in list">
                {{ task.body }}
                <button @click="showTask(task.id)" class="btn btn-primary btn-xs">Edit</button>
                <button @click="deleteTask(task.id)" class="btn btn-danger btn-xs">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                edit: false,
                list: [],
                task: {
                    id: '',
                    body: ''
                },
                tasks: [
                    {
                        id: '1',
                        body: 'This is task 1'
                    },
                    {
                        id: '2',
                        body: 'This is task 2'
                    },
                    {
                        id: '3',
                        body: 'This is task 3'
                    },
                ],
            };
        },
        
        mounted: function() {
            this.fetchTaskList();
        },
        
        methods: {
            fetchTaskList: function() {
                axios.get('api/tasks').then((response) => {
                    this.list = response.data,
                    console.log(response.data),
                    console.log(this.tasks)
                });
            },
 
            createTask: function () {
                axios.post('api/tasks', this.task)
                this.task.body = '';
                this.edit = false;
                this.fetchTaskList();
            },
 
            updateTask: function(id) {
                axios.patch('api/tasks/' + id, this.task)
                this.task.body = '';
                this.edit = false;
                this.fetchTaskList();
            },
 
            showTask: function(id) {
                axios.get('api/tasks/' + id).then(function(response) {
                    this.task.id = response.data.id;
                    this.task.body = response.data.body;
                })
                this.$els.taskinput.focus();
                this.edit = true;
            },
 
            deleteTask: function (id) {
                axios.delete('api/tasks/' + id);
                this.fetchTaskList();
            },
        }
    }
</script>