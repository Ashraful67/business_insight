<template>
  
  <div class="flex flex-wrap">
        <div class="grow">
          <IAvatar size="xs" class="mr-1" :src="avatar_url" />
          <b style="color: rgb(2, 2, 2); margin-left: 3px;" class="font-medium" v-text="creator"></b>
          <b style="color: rgb(8, 8, 8); margin-left: 3px;" class="font-medium" v-text="'Update a Client Feedback. '"></b>
          <b style="color: rgb(13, 127, 226); " class="font-small" v-text="'Client Sentiment Status'"></b>
          <b style="color: rgb(255, 0, 0); margin-left: 3px;" class="font-medium" v-text="html"></b>

          <!-- <i18n-t
            scope="global"
            :keypath="creator.name + 'Left a feedback from client that is '+sentiment"
            tag="span"
            class="text-sm text-neutral-800 dark:text-white"
          >
          </i18n-t> -->

          <!-- <template>
              <b class="font-medium" v-text="creator.name"></b>
            </template> -->
        </div>
        <div class="mt-1 text-sm text-neutral-500 dark:text-neutral-300" v-once>
          {{ localizedDateTime(createdAt) }}
        </div>
      </div>

    <p style="color:green" ref="htmlWrapperRef" v-html="html" @click="handleWrapperClickEvent" />
    
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import Lightbox from './Lightbox.vue'

const props = defineProps({ 
  html: String,
  creator: String,
  createdAt: String,
  avatar_url: String
 })

const activeIndex = ref(null)

const htmlWrapperRef = ref(null)

const imagesUrls = ref([])

function handleWrapperClickEvent(e) {
  if (
    e.target.tagName === 'IMG' &&
    e.target.dataset !== undefined &&
    e.target.dataset.lightboxIndex >= 0 &&
    e.target.parents('a')[0]?.tagName !== 'A'
  ) {
    activeIndex.value = parseInt(e.target.dataset.lightboxIndex)
  }
}

function parseAvailableImages() {
  imagesUrls.value = []

  htmlWrapperRef.value.getElementsByTagName('img').forEach(img => {
    if (
      img.src &&
      imagesUrls.value.indexOf(img.src) === -1 &&
      img.parents('a')[0]?.tagName !== 'A' // no images wrapped in links
    ) {
      imagesUrls.value.push(img.src)
      img.classList.add('cursor-pointer')
      img.classList.add('hover:opacity-90')
      img.dataset.lightboxIndex = imagesUrls.value.length - 1
    }
  })
}

watch(() => props.html, parseAvailableImages, {
  flush: 'post', // after dom updated
})

onMounted(parseAvailableImages)
</script>
