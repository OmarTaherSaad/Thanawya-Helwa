<template>
  <nav>
    <ul class="pagination pagination-sm justify-content-center">
      <li :class="['page-item', {'disabled': isOnFirstPage}]">
        <a class="page-link " @click.prevent="loadPage(1)">
          <i class="fas fa-angle-double-right"></i>
        </a>
      </li>
      <li :class="['page-item', {'disabled': isOnFirstPage}]">
        <a class="page-link" @click.prevent="loadPage('prev')">
          <i class="fas fa-angle-right"></i>
        </a>
      </li>

      <template v-if="notEnoughPages">
        <li v-for="n in totalPage" :key="n" :class="['page-item', {'active': isCurrentPage(n)}]">
          <a class="page-link" @click.prevent="loadPage(n)" v-html="n"></a>
        </li>
      </template>
      <template v-else>
        <li v-for="n in windowSize" :key="n" :class="['page-item', {'active': isCurrentPage(windowStart+n-1)}]">
          <a class="page-link" @click.prevent="loadPage(windowStart+n-1)" v-html="windowStart+n-1"></a>
        </li>
      </template>

      <li :class="['page-item', {'disabled': isOnLastPage}]">
        <a class="page-link" href="" @click.prevent="loadPage('next')">
          <i class="fas fa-angle-left"></i>
        </a>
      </li>
      <li :class="['page-item', {'disabled': isOnLastPage}]">
        <a class="page-link" href="" @click.prevent="loadPage(totalPage)">
          <i class="fas fa-angle-double-left"></i>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
import VuetablePaginationMixin from "vuetable-2/src/components/VuetablePaginationMixin";

export default {
  mixins: [VuetablePaginationMixin]
};
</script>
