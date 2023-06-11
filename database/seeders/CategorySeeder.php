<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Politics and Government',
                'description' => 'Stay updated on political events, elections, government policies, and international relations, as we delve into the intricate world of politics and governance.',
            ],
            [
                'name' => 'Business and Economy',
                'description' => 'Explore the dynamic realm of finance, markets, and business developments. Our coverage includes economic trends, company updates, and insightful analysis to keep you informed about the ever-evolving business landscape.',
            ],
            [
                'name' => 'Technology and Science',
                'description' => 'Unleash your curiosity with the latest innovations and scientific discoveries. From groundbreaking technologies to emerging trends, we explore the frontiers of human ingenuity and keep you abreast of the ever-evolving world of science and technology.',
            ],
            [
                'name' => 'Entertainment',
                'description' => 'Immerse yourself in the glamorous world of entertainment. From captivating movies and TV shows to the latest celebrity news and music releases, we bring you the buzz from the entertainment industry, adding excitement to your everyday life.',
            ],
            [
                'name' => 'Sports',
                'description' => 'Dive into the exhilarating world of sports. Catch up on thrilling matches, follow your favorite athletes, and stay updated on major tournaments and sporting events from across the globe. Get your adrenaline pumping with our comprehensive sports coverage.',
            ],
            [
                'name' => 'Health and Wellness',
                'description' => 'Discover a wealth of information on medical breakthroughs, healthcare policies, and fitness trends to help you lead a healthier and happier life. We provide insights into general well-being and empower you to make informed decisions about your health.',
            ],
            [
                'name' => 'Environment and Climate',
                'description' => 'Join us in promoting environmental awareness and sustainability. Stay informed about pressing environmental issues, climate change, and conservation efforts. Together, we can make a positive impact on our planet and create a greener future for all.',
            ],
            [
                'name' => 'Education',
                'description' => 'Navigate the ever-evolving landscape of education. Stay abreast of educational policies, explore innovative teaching methods, and delve into the latest research and technology trends shaping the future of learning. Empower yourself through knowledge and education.',
            ],
            // [
            //     'name' => 'World News',
            //     'description' => 'Experience the pulse of the world with our comprehensive coverage of major international news events. From global conflicts to humanitarian issues and impactful developments, we bring you the stories that shape our interconnected world.',
            // ],
            [
                'name' => 'Lifestyle',
                'description' => 'Indulge in the finer aspects of life with our coverage of fashion, travel, food, home and garden, and other lifestyle and cultural trends. Discover inspiration, tips, and insights that enhance your everyday experiences and reflect your personal style.',
            ],
            // [
            //     'name' => 'Science Fiction and Fantasy',
            //     'description' => 'Embark on thrilling adventures through the realms of science fiction and fantasy. Immerse yourself in the latest books, movies, and TV shows within these genres, as we explore captivating stories that ignite the imagination and transport you to extraordinary worlds.',
            // ],
            [
                'name' => 'Social Issues',
                'description' => 'Deepen your understanding of crucial social issues that shape our society. From social justice and equality to human rights and beyond, we shed light on important topics, encouraging meaningful discussions and fostering positive change.',
            ],
            [
                'name' => 'Automotive',
                'description' => 'Accelerate into the world of automobiles with our coverage of cars, industry updates, electric vehicles, and transportation advancements. Stay up to speed on the latest trends and innovations driving the automotive industry forward.',
            ],
            [
                'name' => 'Crime and Legal',
                'description' => 'Explore the intricate world of crime, legal proceedings, court cases, law enforcement, and criminal justice. Stay informed about significant developments and gain insights into the complexities of the legal system.',
            ],
            // [
            //     'name' => 'Opinion and Editorials',
            //     'description' => 'Engage with thought-provoking opinions, insightful analysis, and expert commentaries on various topics. Explore diverse perspectives that challenge conventional wisdom, fostering intellectual dialogue and encouraging critical thinking.',
            // ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
