@php
$countItems = [
['count' => $counts->users, 'label' => __('Users')],
['count' => $counts->admins, 'label' => __('Admins')],
['count' => $counts->feeds, 'label' => __('News Feeds')],
['count' => $counts->categories, 'label' => __('Categories')],
['count' => $counts->sources, 'label' => __('Sources')],
['count' => $counts->collectors, 'label' => __('Collectors')],
];
@endphp

<x-app-layout>

    @push('scripts')

    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawVisualization);

        function drawVisualization() {
            var data = google.visualization.arrayToDataTable([
                ['Category', 'View'],
                <?php echo $category_views; ?>
            ]);

            var options = {
                vAxis: {
                    title: 'View Count'
                },
                hAxis: {
                    title: 'Category Name'
                },
                curveType: 'function',
                seriesType: 'bars',
                series: {
                    2: {
                        type: 'line'
                    }
                },
                animation: {
                    duration: 1500,
                    easing: 'out',
                    startup: true
                },
                colors: ['#FFC107'],
                chartArea: {
                    left: 100,
                    right: 100,
                    top: 50,
                    bottom: 100,
                }
            };

            var chart = new google.visualization.ComboChart(document.getElementById('categories_views_chart'));
            chart.draw(data, options);
        }
    </script>
    @endpush

    <div class="py-6">
        <div class="max-w-[95rem] mx-auto px-4 lg:px-8 text-gray-900 dark:text-gray-100">
            <div class="grid grid-cols-12 gap-3">
                @foreach ($countItems as $item)
                <div class="bg-white dark:bg-gray-800 rounded-lg col-span-4 md:col-span-2 p-4 md:p-6">
                    <h3 class="text-2xl md:text-5xl">{{ $item['count'] }}</h3>
                    <p class="text-sm">{{ $item['label'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="pt-4">
                <h3 class="text-2xl pb-2">Categories Performance</h3>
                <div id="categories_views_chart" class="w-full" style="height: 70vh;"></div>
            </div>
        </div>
    </div>
</x-app-layout>
