<template>
    <div class="min-h-screen bg-gray-100 flex items-center p-3">
        <div class="w-full md:w-1/3 bg-white mx-auto rounded py-5 px-3">
            <h1 class="mb-4 font-bold">Run a command</h1>
            <div class="mb-4">
                <input type="text" v-model="command" placeholder="Enter command" class="w-full">
            </div>
            <div class="mb-4">
                <button :disabled="processing" class="py-2 px-10 bg-sky-500 rounded mr-2 text-white" @click="($event) => onSubmit('a')">Run A</button>
                <button :disabled="processing" v-if="user" class="py-2 px-10 bg-red-700 rounded text-white" @click="($event) => onSubmit('b')">Run B</button>
            </div>

            <h4 v-if="!user">
                Please Login to enable command B
                <Link :href="route('login')" class="px-3 text-red-500">Log in</Link>
            </h4>

            <h4 v-if="user" class="text-slate-500">Commands are running in background.</h4>
        </div>
    </div>
</template>


<!-- Script  -->
<script setup lang="ts">

    import { Link, usePage } from '@inertiajs/vue3';
    import axios from 'axios';
    import { ref, onMounted } from 'vue';

    //
    let command = ref('');
    let processing = ref(false)
    let user = usePage().props.auth.user;

    const onSubmit = (type: string) => {
        axios.post('/api/execute', {
            type,
            command: command.value
       })
        .then(res => {
            command.value = '';
            alert(res.data.message);
        })
        .catch(e => {
            handleError(e.response)
        })
    }

    const handleError = (error: any) => {

        let errData = error?.data;
        let message = errData?.message || error.message;

        // Validation Error
        if (errData?.errors) {
            let keys = Object.keys(errData.errors);
            message = errData.errors[keys[0]][0];
        }

        //
        message = message || 'Operation not successful';
        alert(message);
    }

    //
    const loadResponse = () => {
        axios.get('/api/responses')
        .then(res => {
            let data = res.data?.data;
            if(data) alert('Result is: ' + data.data);
        })
        .catch(e => {
            //handleError(e.response);
        })
    }

    onMounted(() => {
        setInterval(loadResponse, 15000);
    })

</script>
