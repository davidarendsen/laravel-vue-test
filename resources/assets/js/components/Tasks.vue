<template>
    <div id="tasks-component">
        <h1>My Tasks</h1>

        <h4>New Task</h4>
        <form action="#" @submit.prevent="edit ? updateTask(task.id) : createTask()">
            <div class="input-group">
                <input v-model="task.body" el:taskinput type="text" name="body" class="form-control" autofocus>
                <span class="input-group-btn">
                    <button v-show="!edit" type="submit" class="btn btn-primary">New Task</button>
                    <button v-show="edit" type="submit" class="btn btn-primary">Edit Task</button>
                </span>
            </div>
        </form>

        <h4>All Tasks</h4>
        <ul class="list-group">
            <li class="list-group-item" v-for="task in tasks">
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
                tasks: [],
                task: {
                    id: '',
                    body: ''
                },
            };
        },
        
        mounted: function() {
            this.fetchTaskList();
            console.log('Tasks component loaded');
        },
        
        methods: {
            fetchTaskList: function() {
                axios.get('api/tasks').then((response) => {
                    this.tasks = response.data
                }).catch((response) => {
                    if (response.status === 401) {
                        window.location.href = "/login";
                    }
                });
            },
 
            createTask: function() {
                axios.post('api/tasks', this.task).then((response) => {
                    this.task.body = '';
                    this.fetchTaskList();
                }).catch((response) => {
                    if (response.status === 401) {
                        window.location.href = "/login";
                    }
                });
                this.edit = false;
            },
 
            updateTask: function(id) {
                axios.put('api/tasks/' + id, this.task).then((response) => {
                    this.task.body = '';
                    this.fetchTaskList();
                }).catch((response) => {
                    //error fallback
                    if (response.status === 401) {
                        window.location.href = "/login";
                    }
                });
                this.edit = false;
            },
 
            showTask: function(id) {
                axios.get('api/tasks/' + id).then((response) => {
                    this.task.id = response.data.id,
                    this.task.body = response.data.body
                }).catch((response) => {
                    if (response.status === 401) {
                        window.location.href = "/login";
                    }
                });
                //this.$refs.taskinput.focus();
                this.edit = true;
            },
 
            deleteTask: function(id) {
                axios.delete('api/tasks/' + id).then((response) => {
                    this.fetchTaskList();
                }).catch((response) => {
                    if (response.status === 401) {
                        window.location.href = "/login";
                    }
                });
            },
        }
    }
</script>