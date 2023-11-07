<template>
  <div v-if="all_pages && all_pages > 1">
    <ul class="pagination float-right">
      <li class="page-item">
        <a class="page-link" @click.prevent="changePage(1)">
          <i class="fas fa-angle-double-left" />
        </a>
      </li>
      <li v-for="page in all_pages" class="page-item" :class="page === current_page ? 'active' : ''">
        <a class="page-link" @click.prevent="changePage(page)">
          {{ page }}
        </a>
      </li>
      <li class="page-item">
        <a class="page-link" @click.prevent="changePage(all_pages)">
          <i class="fas fa-angle-double-right" />
        </a>
      </li>
    </ul>
    {{ current_page }} / {{ all_pages }}
  </div>
</template>

<script>
export default {
    props: ['all_pages', 'current_page', 'changePage']
}
</script>
