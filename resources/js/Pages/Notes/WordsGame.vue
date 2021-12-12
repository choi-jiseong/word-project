<template>
        <link
            href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
            rel="stylesheet"
            />
    <new-layout title="Dashboard">
        <template #header>
            <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">

            <nav id="store" class="w-full z-30 top-0 px-6 py-1">
                <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">

                <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl " href="#">
				    WORD TEST
			    </a>

              </div>
              <div class="text-left mt-10">
                    <Link :href="'/notes/show/'+note.id" method="get"><span class="material-icons-outlined hover:text-gray-300">
                            exit_to_app
                            </span></Link>
              </div>
            </nav>
            </div>
        </template>
    <template #content>
        <section class="bg-white py-3" >
            <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">
                <div class="w-full md:w-3/5 mx-auto p-8">
                    <Carousel>
                        <Slide v-for="(word, index) in note.words" :key="word.id">
                            <div @click="checkWord(index)" v-if="currentWord != index" class="carousel__item">
                                <div>
                                    {{ word.language }}
                                </div>
                            </div>
                            <div @click="checkWord(index)" v-if="currentWord == index" class="carousel__item">{{ word.mean }}</div>

                        </Slide>
                        <template #addons>
                            <Pagination />
                            <Navigation />
                        </template>
                    </Carousel>
                </div>
            </div>
        </section>
    </template>


    </new-layout>
</template>

<script>
    import { defineComponent } from 'vue'

    import NewLayout from '@/Layouts/NewLayout.vue'
    import 'vue3-carousel/dist/carousel.css';
    import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
    import {
        Link
    } from '@inertiajs/inertia-vue3'
    export default defineComponent({
        props : ['note'],
        components: {
            NewLayout,
            Carousel,
            Slide,
            Pagination,
            Navigation,
            Link
        },
        data() {
            return {
                clickWord : false,
                currentWord : null,
            }
        },
        methods: {
            checkWord(index) {
                if (this.currentWord === index) {
                    this.currentWord = null
                }else{
                    this.currentWord = index
                }
            }
        },
    })
</script>

<style>
.carousel__item {
  min-height: 200px;
  width: 100%;
  background-color: var(--vc-clr-primary);
  color:  var(--vc-clr-white);
  font-size: 20px;
  border-radius: 8px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.carousel__slide {
  padding: 10px;
}

.carousel__prev,
.carousel__next {
  box-sizing: content-box;
  border: 5px solid white;
}
</style>
