<template>
    <div class="flex items-center justify-center h-screen">
        <form @submit.prevent="sendForm" class="
            border-8 border-gray-200 rounded-xl
            w-[500px] -mt-14 p-8
            flex flex-col gap-y-3
        ">
            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Заголовок</span>
                <input class="
                px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner
                focus-visible:outline-brand-2 outline-2
            " type="text" v-model="data.title">
            </label>

            <input v-model="data.datetime" type="datetime-local" />

            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Описание</span>
                <textarea class="
                    px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner
                    focus-visible:outline-brand-2 outline-2
                " rows="6" v-model="data.description" />
            </label>

            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Сервис</span>
                <select class="px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner
                focus-visible:outline-brand-2 outline-2" v-model="data.service_name">
                    <option class="px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner
                focus-visible:outline-brand-2 outline-2" v-for="service in data.services">{{ service.title }}</option>
                </select>
            </label>

            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Оценка</span>

                <StarsRating
                    v-model="rating"
                    :stars="5"
                />
            </label>


            <button class="
                grid place-content-center w-full p-2 mt-1 border-2 border-gray-300 rounded-md shadow-sm outline-none bg-white
                text-lg font-semibold tracking-wide text-gray-400
                transition-all
                focus-visible:bg-brand-2 focus-visible:border-green-700 focus-visible:text-green-800 focus-visible:shadow-xl
                hover:bg-brand-2 hover:border-green-700 hover:text-green-800 hover:shadow-xl
            " type="submit">Отправить</button>
        </form>
    </div>
</template>
<script setup lang="ts">
import {onBeforeMount, reactive, ref} from 'vue';
import axios from 'axios';
import env from '@/env.json'
import router from '@/router';
import StarsRating from '../components/StarsRating.vue';

const rating = ref(1);



onBeforeMount(() => {
    axios.get<IndexServiceResponse>(env.backend_url + `/services`)
        .then(serviceResponse => {
            data.services = serviceResponse.data
        }).catch(error => {
        alert(error);
    });
});

const data = reactive({
    description: '',
    title: '',
    datetime: '',
    service_name: '',
    rating: ''
});

const sendForm = async () => {
    try {
        const response = await sendFormImpl();
        if (!response.data.id)
            throw new Error('Ошибка сервера');
        await router.push({ name: 'feedback-show', params: { id: response.data.id } });
    } catch (error) {
        alert(error);
    }
}

const sendFormImpl = async () => {
    return await axios.post<StoreFeedbackResponse>(env.backend_url + '/feedbacks', {
        'description': data.description,
        'title': data.title,
        'datetime':  new Date(data.datetime).getTime(),
        'service_name': data.service_name,
        'rating': rating.value
    });
}


interface StoreFeedbackResponse {
    id: number
}

interface IndexServiceResponse {
    title: string;
}
</script>
