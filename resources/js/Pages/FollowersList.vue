<template>
<link
  href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
  rel="stylesheet"
/>

  <div class="w-5/6 mx-auto">
    <div class="flex flex-col overflow-auto lg:overflow-visible">
      <div class="flex lg:justify-between border-b-2 border-fuchsia-900 pb-1">
        <h2 class="text-2xl text-gray-500 font-bold">Followers</h2>

      </div>
      <table class="table w-full text-gray-900 border-separate space-y-6 text-sm">
        <thead class="bg-gray-900 text-white">
          <tr>
            <th class="p-3 text-left">Name</th>
            <th class="p-3 text-left">Mail</th>

            <th class="p-3 text-left">Action</th>
          </tr>
        </thead>
        <tbody>

          <tr v-for="follower in followers" :key="follower.id" class="bg-gray-200 lg:text-black">
            <td class="p-3 font-medium">{{ follower.name }}</td>
            <td class="p-3">{{ follower.email }}</td>

            <td class="p-3">
              <a href="#" class="text-gray-900 hover:text-gray-100 mr-2">
                <Link :href="'/profiles/'+follower.name" method="get"><i class="material-icons-outlined text-base">visibility</i></Link>
              </a>
              <a href="#" class="text-yellow-400 hover:text-gray-100 mx-2">
                <i v-if="$page.props.user.id != follower.id" @click="playChat(follower.id)" class="material-icons-outlined text-base">chat</i>
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</template>

<script>
    import {
        Link
    } from '@inertiajs/inertia-vue3'
export default {
    props : ['followers'],
    components : {
        Link,
    },
    methods: {
        playChat(userId) {
            this.$inertia.post('/chat/room/create', {chatUserId : userId});
        }
    },

}
</script>

<style>

    .table {
    border-spacing: 0 15px;
  }

  i {
    font-size: 1rem !important;
  }

  .table tr {
    border-radius: 20px;
  }

  tr td:nth-child(n + 3),
  tr th:nth-child(n + 3) {
    border-radius: 0 0.625rem 0.625rem 0;
  }

  tr td:nth-child(1),
  tr th:nth-child(1) {
    border-radius: 0.625rem 0 0 0.625rem;
  }

</style>
