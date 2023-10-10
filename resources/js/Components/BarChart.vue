<template>
  <div class="chart">
    <apexchart

    width="100%"
        height="400px"
        type="area"

    :options="chartOptions" :series="series"></apexchart>
  </div>
</template>

<script>
import VueApexCharts from "vue3-apexcharts";

export default {
  components: {
    apexchart: VueApexCharts,
  },
  data() {
    return {
      chartOptions: {
        chart: {
          id: "basic-bar",
        },
        xaxis: {
          categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        },
      },
      series: [
        {
          name: "opened",
          data: [],
        },
        {
          name: "closed",
          data: [],
        },
      ],
    };
  },
  created() {
    this.series[0].data = this.opened.map(item => item.count); // map 'count' from each object in the 'opened' array
    this.series[1].data = this.closed.map(item => item.count); // map 'count' from each object in the 'closed' array
  },
  props: ['opened', 'closed']
};
</script>

<style scoped>

</style>
