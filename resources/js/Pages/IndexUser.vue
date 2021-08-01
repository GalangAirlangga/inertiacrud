<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden p-5">
          <Table
            :filters="queryBuilderProps.filters"
            :search="queryBuilderProps.search"
            :columns="queryBuilderProps.columns"
            :on-update="setQueryBuilder"
            :meta="users"
          >
            <template #head>
              <tr>
                <th v-show="showColumn('name')" @click.prevent="sortBy('name')">
                  Name
                </th>
                <th
                  v-show="showColumn('email')"
                  @click.prevent="sortBy('email')"
                >
                  Email
                </th>
                <th v-show="showColumn('role')" @click.prevent="sortBy('role')">
                  Role
                </th>
                <th
                  v-show="showColumn('status')"
                  @click.prevent="sortBy('status')"
                >
                  Status
                </th>
                <th>Action</th>
              </tr>
            </template>

            <template #body>
              <tr v-for="user in users.data" :key="user.id">
                <td
                  v-show="showColumn('name')"
                  class="px-6 py-4 whitespace-nowrap"
                >
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <img
                        class="h-10 w-10 rounded-full"
                        v-bind:src="`${user.profile_photo_url}`"
                        alt=""
                      />
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">
                        {{ user.name }}
                      </div>
                    </div>
                  </div>
                </td>

                <td v-show="showColumn('email')">{{ user.email }}</td>
                <td v-show="showColumn('role')">{{ user.role[0] }}</td>
                <td v-show="showColumn('status')">{{ user.status }}</td>
                <td>
                  <Menu as="div" class="relative inline-block text-left">
                    <div>
                      <MenuButton
                        class="
                          inline-flex
                          justify-center
                          w-full
                          px-4
                          py-2
                          text-sm
                          font-medium
                          text-purple-500
                          bg-white
                          rounded-md
                          border border-purple-500
                          hover:border-purple-300
                          hover:bg-purple-500
                          hover:text-white
                          focus:outline-none
                          focus-visible:ring-2
                          focus-visible:ring-white
                          focus-visible:ring-opacity-75
                        "
                      >
                        Options
                        <ChevronDownIcon
                          class="
                            w-5
                            h-5
                            ml-2
                            -mr-1
                            text-purple-400
                            hover:text-purple-500
                          "
                          aria-hidden="true"
                        />
                      </MenuButton>
                    </div>

                    <transition
                      enter-active-class="transition duration-100 ease-out"
                      enter-from-class="transform scale-95 opacity-0"
                      enter-to-class="transform scale-100 opacity-100"
                      leave-active-class="transition duration-75 ease-in"
                      leave-from-class="transform scale-100 opacity-100"
                      leave-to-class="transform scale-95 opacity-0"
                    >
                      <MenuItems
                        class="
                          z-10
                          absolute
                          right-0
                          w-56
                          mt-2
                          origin-top-right
                          bg-white
                          divide-y divide-gray-100
                          rounded-md
                          shadow-lg
                          ring-1 ring-black ring-opacity-5
                          focus:outline-none
                        "
                      >
                        <div class="px-1 py-1">
                          <MenuItem v-slot="{ active }">
                            <button
                              :class="[
                                active
                                  ? 'bg-purple-500 text-white'
                                  : 'text-gray-900',
                                'group flex rounded-md items-center w-full px-2 py-2 text-sm',
                              ]"
                            >
                              <PencilIcon
                                :active="active"
                                class="
                                  w-5
                                  h-5
                                  mr-2
                                  hover:text-white
                                  text-purple-400
                                "
                                aria-hidden="true"
                              />
                              Edit
                            </button>
                          </MenuItem>
                        </div>
                        <div class="px-1 py-1">
                          <MenuItem v-slot="{ active }">
                            <button
                              :class="[
                                active
                                  ? 'bg-purple-500 text-white'
                                  : 'text-gray-900',
                                'group flex rounded-md items-center w-full px-2 py-2 text-sm',
                              ]"
                            >
                              <ArchiveIcon
                                :active="active"
                                class="
                                  w-5
                                  h-5
                                  mr-2
                                  hover:text-white
                                  text-purple-400
                                "
                                aria-hidden="true"
                              />
                              Archive
                            </button>
                          </MenuItem>
                        </div>

                        <div class="px-1 py-1">
                          <MenuItem v-slot="{ active }">
                            <button
                              :class="[
                                active
                                  ? 'bg-purple-500 text-white'
                                  : 'text-gray-900',
                                'group flex rounded-md items-center w-full px-2 py-2 text-sm',
                              ]"
                            >
                              <TrashIcon
                                :active="active"
                                class="
                                  w-5
                                  h-5
                                  mr-2
                                  hover:text-white
                                  text-purple-400
                                "
                                aria-hidden="true"
                              />
                              Delete
                            </button>
                          </MenuItem>
                        </div>
                      </MenuItems>
                    </transition>
                  </Menu>
                </td>
              </tr>
            </template>
          </Table>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import {
  InteractsWithQueryBuilder,
  Tailwind2,
} from "@protonemedia/inertiajs-tables-laravel-query-builder";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import {
  ChevronDownIcon,
  ArchiveIcon,
  DuplicateIcon,
  CursorClickIcon,
  PencilIcon,
  TrashIcon,
} from "@heroicons/vue/solid";
//import { ChevronDownIcon } from "@heroicons/vue/solid";
// import ArchiveIcon from "./archive-icon.vue";
// import DuplicateIcon from "./duplicate-icon.vue";
// import CursorClickIcon  from "./move-icon.vue";
// import PencilIcon  from "./edit-icon.vue";
// import TrashIcon from "./delete-icon.vue";
export default {
  mixins: [InteractsWithQueryBuilder],

  components: {
    AppLayout,
    Menu,
    MenuButton,
    MenuItems,
    MenuItem,
    ChevronDownIcon,
    ArchiveIcon,
    DuplicateIcon,
    CursorClickIcon,
    PencilIcon,
    TrashIcon,
    Table: Tailwind2.Table,
  },

  props: {
    users: Object,
  },
};
</script>
