<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $this->faker->locale('en_US');
        
        $categories = [
            'Tech_Trends' => [
                'titles' => [
                    '{tech} in {year}: Revolutionary Changes Ahead',
                    'Why {tech} is the Future of Development',
                    'Top {tech} Projects That Changed Everything',
                    'Building Enterprise Solutions with {tech}',
                    'The {tech} Revolution: A Deep Dive'
                ],
                'technologies' => [
                    'AI/ML', 'Blockchain', 'Cloud Native', 'DevOps',
                    'Edge Computing', 'Flutter', 'GraphQL', 'Kubernetes',
                    'Microservices', 'NextJS', 'React Native', 'Rust',
                    'Serverless', 'Web3', 'Zero Trust Security'
                ],
                'content_templates' => [
                    "# {tech} - Transforming the Digital Landscape\n\n" .
                    "## The Evolution of {tech}\n" .
                    "The tech industry is witnessing a paradigm shift with {tech} leading the charge. From startups to enterprise giants, organizations are leveraging its potential to drive innovation.\n\n" .
                    "## Key Innovations\n" .
                    "- Seamless Integration Capabilities\n" .
                    "- Enhanced Performance Metrics\n" .
                    "- Revolutionary User Experiences\n" .
                    "- Enterprise-Grade Security\n\n" .
                    "## Industry Impact\n" .
                    "The adoption of {tech} has revolutionized:\n" .
                    "1. Development Workflows\n" .
                    "2. System Architecture\n" .
                    "3. User Engagement\n" .
                    "4. Business Scalability\n\n" .
                    "## Future Prospects\n" .
                    "As we look ahead, {tech} continues to evolve, promising even more groundbreaking developments in the coming years."
                ]
            ],
            'Developer_Life' => [
                'titles' => [
                    'The Art of {topic} Engineering',
                    'Mastering {topic}: From Junior to Senior',
                    '{topic} Architecture: Best Practices',
                    'Building Scalable {topic} Systems',
                    'Modern {topic}: A Practical Guide'
                ],
                'topics' => [
                    'System Design', 'Code Quality', 'Team Leadership',
                    'Performance Optimization', 'Technical Architecture',
                    'Cloud Infrastructure', 'API Design', 'DevOps Culture',
                    'Software Testing', 'Continuous Deployment'
                ],
                'content_templates' => [
                    "# Mastering {topic}: A Comprehensive Guide\n\n" .
                    "## Understanding the Fundamentals\n" .
                    "Success in {topic} requires a solid foundation and continuous learning. Let's explore the key principles that drive excellence.\n\n" .
                    "## Essential Skills\n" .
                    "- Strategic Problem Solving\n" .
                    "- Technical Excellence\n" .
                    "- Collaborative Mindset\n" .
                    "- Innovation Focus\n\n" .
                    "## Best Practices\n" .
                    "1. Embrace Automation\n" .
                    "2. Practice Clean Code\n" .
                    "3. Implement Robust Testing\n" .
                    "4. Document Effectively\n\n" .
                    "## Real-World Implementation\n" .
                    "Learn from practical examples and case studies that demonstrate successful {topic} implementation strategies."
                ]
            ]
        ];

        $category = array_rand($categories);
        $categoryData = $categories[$category];
        $titleTemplate = $this->faker->randomElement($categoryData['titles']);
        
        if ($category === 'Tech_Trends') {
            $tech = $this->faker->randomElement($categoryData['technologies']);
            $title = str_replace(['{tech}', '{year}'], [$tech, date('Y')], $titleTemplate);
            $content = str_replace('{tech}', $tech, $this->faker->randomElement($categoryData['content_templates']));
        } else {
            $topic = $this->faker->randomElement($categoryData['topics']);
            $title = str_replace('{topic}', $topic, $titleTemplate);
            $content = str_replace('{topic}', $topic, $this->faker->randomElement($categoryData['content_templates']));
        }

        $images = [
            'blog1.jpg', 'blog2.jpg', 'blog3.jpg', 'blog4.jpg', 'blog5.jpg',
            'blog6.jpg', 'blog7.jpg', 'blog8.jpg', 'blog9.jpg', 'blog10.jpg'
        ];
        
        return [
            'post_title' => $title,
            'content' => $content,
            'photo' => $this->faker->randomElement($images),
            'user_id' => User::factory(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            'updated_at' => function (array $attributes) {
                return $attributes['created_at'];
            },
        ];
    }
} 