<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'name' => 'Анна Петрова',
                'email' => 'anna.petrova@example.com',
                'phone' => '+7 (985) 123-45-67',
                'subject' => 'Заказ портрета',
                'message' => 'Здравствуйте! Хотела бы заказать портрет маслом для подарка на день рождения. Размер примерно 40x50 см. Есть фотография, с которой можно писать. Сколько будет стоить и какие сроки?',
                'type' => 'order',
                'is_read' => false,
                'is_replied' => false,
                'created_at' => now()->subDays(2),
            ],
            [
                'name' => 'Михаил Сидоров',
                'email' => 'mikhail.sidorov@example.com',
                'phone' => null,
                'subject' => 'Сотрудничество в области иллюстрации',
                'message' => 'Добрый день! Я представляю издательство "Радуга". Мы ищем иллюстратора для детской книги. Ваши работы нам очень понравились. Можем ли мы обсудить возможное сотрудничество?',
                'type' => 'collaboration',
                'is_read' => true,
                'is_replied' => false,
                'admin_notes' => 'Интересное предложение, нужно изучить портфолио издательства',
                'created_at' => now()->subDays(5),
            ],
            [
                'name' => 'Елена Николаева',
                'email' => 'elena.nikolaeva@example.com',
                'phone' => '+7 (926) 987-65-43',
                'subject' => 'Вопрос о технике живописи',
                'message' => 'Привет! Очень нравятся ваши пейзажи. Хотела узнать, какими красками вы пишете? И есть ли у вас мастер-классы?',
                'type' => 'general',
                'is_read' => true,
                'is_replied' => true,
                'admin_notes' => 'Отвечено по email, предложила записаться на мастер-класс',
                'created_at' => now()->subDays(7),
            ],
            [
                'name' => 'Дмитрий Козлов',
                'email' => 'dmitry.kozlov@example.com',
                'phone' => '+7 (903) 456-78-90',
                'subject' => 'Заказ корпоративного портрета',
                'message' => 'Здравствуйте! Наша компания хотела бы заказать портрет директора для офиса. Размер большой, примерно 80x100 см. Техника - масло. Можете ли вы взяться за такую работу?',
                'type' => 'order',
                'is_read' => true,
                'is_replied' => true,
                'admin_notes' => 'Согласовали размер и стоимость, ждем встречи',
                'created_at' => now()->subDays(10),
            ],
            [
                'name' => 'Ольга Смирнова',
                'email' => 'olga.smirnova@example.com',
                'phone' => null,
                'subject' => 'Покупка готовой работы',
                'message' => 'Добрый день! Увидела в вашем портфолио картину "Осенний парк". Она еще доступна для покупки? Если да, то какая цена?',
                'type' => 'general',
                'is_read' => false,
                'is_replied' => false,
                'created_at' => now()->subHours(6),
            ],
            [
                'name' => 'Игорь Волков',
                'email' => 'igor.volkov@example.com',
                'phone' => '+7 (915) 234-56-78',
                'subject' => 'Участие в выставке',
                'message' => 'Здравствуйте! Я куратор галереи "Современное искусство". Хотели бы пригласить вас к участию в групповой выставке молодых художников. Мероприятие планируется на декабрь.',
                'type' => 'collaboration',
                'is_read' => false,
                'is_replied' => false,
                'created_at' => now()->subHours(12),
            ],
            [
                'name' => 'Мария Кузнецова',
                'email' => 'maria.kuznetsova@example.com',
                'phone' => '+7 (916) 345-67-89',
                'subject' => 'Заказ свадебного портрета',
                'message' => 'Привет! Хотим заказать свадебный портрет по фотографии. Свадьба была в прошлом году, хотелось бы увековечить этот момент на холсте. Каковы ваши условия работы?',
                'type' => 'order',
                'is_read' => true,
                'is_replied' => false,
                'admin_notes' => 'Показалась подходящая работа, нужно обсудить детали',
                'created_at' => now()->subDays(1),
            ],
            [
                'name' => 'Андрей Морозов',
                'email' => 'andrey.morozov@example.com',
                'phone' => null,
                'subject' => 'Вопрос о доставке',
                'message' => 'Здравствуйте! Живу в другом городе. Возможна ли доставка готовых работ? Какие варианты доставки у вас есть?',
                'type' => 'general',
                'is_read' => true,
                'is_replied' => true,
                'admin_notes' => 'Объяснила варианты доставки, отправила прайс',
                'created_at' => now()->subDays(3),
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}