<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Question::query()->whereBetween('id', [1, 1000])->first()) {
            return;
        }

        $dispatcher = Question::getEventDispatcher();
        Question::unsetEventDispatcher();
        $category = Category::all()->pluck('id');

        Question::query()->insert([
            # Базовые категории
            ['category_id' => $category[0], 'client_title' => 'Внешний вид профессионала', 'psychologist_title' => 'Внешний вид профессионала', 'type' => 'one', 'psychologist_reverse' => NULL, 'client_reverse' => NULL],
            # Гендерные и семейные вопросы
            ['category_id' => $category[4], 'client_title' => 'Биологическая обусловленность гендерных различий', 'psychologist_title' => 'Биологическая обусловленность гендерных различий', 'type' => 'one', 'psychologist_reverse' => NULL, 'client_reverse' => NULL],
            ['category_id' => $category[4], 'client_title' => 'Взаимосвязь гендерных ролей и личного благополучия', 'psychologist_title' => 'Взаимосвязь гендерных ролей и личного благополучия', 'type' => 'one', 'psychologist_reverse' => NULL, 'client_reverse' => NULL],
            ['category_id' => $category[4], 'client_title' => 'Сакральность сексуальной жизни', 'psychologist_title' => 'Сакральность сексуальной жизни', 'type' => 'one', 'psychologist_reverse' => NULL, 'client_reverse' => NULL],
            ['category_id' => $category[4], 'client_title' => 'Ценность отношений', 'psychologist_title' => 'Ценность отношений', 'type' => 'one', 'psychologist_reverse' => NULL, 'client_reverse' => NULL],
            # ЛГБТ
            ['category_id' => $category[5], 'client_title' => 'Отношение к однополым связям', 'psychologist_title' => 'Отношение к однополым связям', 'type' => 'one', 'psychologist_reverse' => NULL, 'client_reverse' => NULL],
            ['category_id' => $category[5], 'client_title' => 'Причины ЛГБТ-особенностей', 'psychologist_title' => 'Причины ЛГБТ-особенностей', 'type' => 'one', 'psychologist_reverse' => NULL, 'client_reverse' => NULL],
            ['category_id' => $category[5], 'client_title' => 'Отношение к гендерному разнообразию', 'psychologist_title' => 'Отношение к гендерному разнообразию', 'type' => 'one', 'psychologist_reverse' => NULL, 'client_reverse' => NULL],
            # Репродуктивные вопросы и родительство
            ['category_id' => $category[6], 'client_title' => 'Причины бесплодия', 'psychologist_title' => 'Причины бесплодия', 'type' => 'one', 'psychologist_reverse' => NULL, 'client_reverse' => NULL],
            ['category_id' => $category[6], 'client_title' => 'Аборты', 'psychologist_title' => 'Аборты', 'type' => 'one', 'psychologist_reverse' => NULL, 'client_reverse' => NULL],
            ['category_id' => $category[6], 'client_title' => 'Родительство как ценность', 'psychologist_title' => 'Родительство как ценность', 'type' => 'one', 'psychologist_reverse' => NULL, 'client_reverse' => NULL],
            # Мировоззренческие установки
            ['category_id' => $category[7], 'client_title' => 'Религиозные установки', 'psychologist_title' => 'Религиозные установки', 'type' => 'one', 'psychologist_reverse' => NULL, 'client_reverse' => NULL],
            # Склонность к непознаваемому
            ['category_id' => $category[8], 'client_title' => 'Я думаю, что не всё в психике человека можно изучить и объяснить.', 'psychologist_title' => 'Я думаю, что не всё в психике человека можно изучить и объяснить.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[8], 'client_title' => 'Есть вещи, которые невозможно понять разумом, но можно почувствовать.', 'psychologist_title' => 'Есть вещи, которые невозможно понять разумом, но можно почувствовать.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[8], 'client_title' => 'Я доверяю своим предчувствиям, даже если кажется, что они не обоснованы.', 'psychologist_title' => 'Я доверяю своим предчувствиям, даже если кажется, что они не обоснованы.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[8], 'client_title' => 'Я считаю, что всему можно найти рациональное объяснение, если приложить достаточно сил и внимания.', 'psychologist_title' => 'Я считаю, что всему можно найти рациональное объяснение, если приложить достаточно сил и внимания.', 'type' => 'many', 'psychologist_reverse' => true, 'client_reverse' => true],
            ['category_id' => $category[8], 'client_title' => 'Опираясь в своем мнении и поведении на предчувствия и интуицию, можно совершить большую ошибку.', 'psychologist_title' => 'Опираясь в своем мнении и поведении на предчувствия и интуицию, можно совершить большую ошибку.', 'type' => 'many', 'psychologist_reverse' => true, 'client_reverse' => true],
            # Отношение к магическим и эзотерическим практикам
            ['category_id' => $category[9], 'client_title' => 'Мне нужен психолог, который понимает, что проблемы человека могут быть связаны не только с физическим миром.', 'psychologist_title' => 'Я использую в своей практике инструменты, опирающиеся на духовные практики.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[9], 'client_title' => 'У меня в жизни был мистический или необъяснимый опыт.', 'psychologist_title' => 'Как психолог, я опираюсь в своей работе на знания, выходящие за пределы признанного наукой.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[9], 'client_title' => 'Я с уважением отношусь к нетипичным подходам к пониманию человеческой природы.', 'psychologist_title' => 'Я считаю, что мистические практики могут быть эффективным инструментом в работе психолога.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[9], 'client_title' => 'У меня был опыт или переживания, в основе которых лежит мистическая природа.', 'psychologist_title' => 'Я верю, что у каждого человека есть своё предназначение, и я могу помочь клиенту найти своё.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[9], 'client_title' => 'Я думаю, что многое из того, что непосвященным кажется суеверием или иллюзией, на самом деле близко к истине.', 'psychologist_title' => 'Я думаю, что многое из того, что непосвященным кажется суеверием или иллюзией, на самом деле близко к истине.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            # Доверие к научному знанию
            ['category_id' => $category[10], 'client_title' => 'Я считаю, что психология — в первую очередь наука, и должна опираться на научно-доказанную базу.', 'psychologist_title' => 'Я считаю, что психология — в первую очередь наука, и должна опираться на научно-доказанную базу.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[10], 'client_title' => 'Важнее, чтобы терапевт был хорошим специалистом, умел чувствовать и понимать клиента, чем пользовался только теми методами, которые прошли экспериментальную проверку.', 'psychologist_title' => 'Важнее, чтобы терапевт был хорошим специалистом, умел чувствовать и понимать клиента, чем пользовался только теми методами, которые прошли экспериментальную проверку.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[10], 'client_title' => 'Я скорее предпочту психолога, работающего в научно-доказательном подходе, чем специализирующегося в области моего запроса.', 'psychologist_title' => 'Внедряя новые методы или подходы в свою работу, я больше руководствуюсь тем, насколько они выглядят для меня полезными, чем тем, доказана ли их эффективность исследователями.', 'type' => 'many', 'psychologist_reverse' => true, 'client_reverse' => false],
            ['category_id' => $category[10], 'client_title' => 'Я считаю, что доказательная психотерапия — это миф.', 'psychologist_title' => 'Если психолог будет работать только методами, эффективность которых подтверждена исследователями — его инструментарий работы будет критически мал.', 'type' => 'many', 'psychologist_reverse' => true, 'client_reverse' => true],
            ['category_id' => $category[10], 'client_title' => 'Я думаю, что психологу-профессионалу можно довериться в вопросе подбора инструментов и методов психотерапевтической работы.', 'psychologist_title' => 'Я думаю, что психологу не стоит ограничивать себя только научно-доказательными подходами.', 'type' => 'many', 'psychologist_reverse' => true, 'client_reverse' => true],
            # Допустимость юмора
            ['category_id' => $category[11], 'client_title' => 'Я согласен с высказыванием, что «Смех — лучшее лекарство».', 'psychologist_title' => 'Юмор — естественная составляющая терапевтического общения.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[11], 'client_title' => 'Наличие у специалиста чувства юмора свидетельствует о его способности сопереживать.', 'psychologist_title' => 'Юмор в общении с клиентом позволяет снизить тревожность и убрать барьеры коммуникации.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[11], 'client_title' => 'Когда специалист шутит, мне кажется, что он несерьезно относится к своей работе.', 'psychologist_title' => 'Я не думаю, что в моей работе уместен юмор.', 'type' => 'many', 'psychologist_reverse' => true, 'client_reverse' => true],
            ['category_id' => $category[11], 'client_title' => 'Я болезненно реагирую на шутки в свой адрес.', 'psychologist_title' => 'Психолог не должен шутить с клиентом, чтобы не показать своего неуважения к его проблеме и личности.', 'type' => 'many', 'psychologist_reverse' => true, 'client_reverse' => true],
            # Склонность к ментальным абстракциям
            ['category_id' => $category[12], 'client_title' => 'Для меня важно находиться в непрерывном процессе саморазвития и обогощать процессы своей мыслительной деятельности.', 'psychologist_title' => 'На прямые вопросы клиента я обычно стараюсь дать полноценный', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[12], 'client_title' => 'Для меня ценнее обсудить свои мысли и услышать размышления психолога на интересующую меня тему, нежели обращаться к конкретике моей проблемы.', 'psychologist_title' => 'Я могу поддержать философскую беседу во время сессии с клиентом.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[12], 'client_title' => 'Я стремлюсь к предельной осознанности своих действий, на выявление смысла событий и их связь между собой.', 'psychologist_title' => 'Я стремлюсь к предельной осознанности своих действий, на выявление смысла событий и их связь между собой.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[12], 'client_title' => 'Я склонен к теоретическому мышлению и стремлюсь к проникновению в сущность вещей и процессов.', 'psychologist_title' => 'Я склонен к теоретическому мышлению и стремлюсь к проникновению в сущность вещей и процессов.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            # Склонность к метафорическому языку
            ['category_id' => $category[13], 'client_title' => 'Мне часто проще объяснить что-то через метафору, чем напрямую.', 'psychologist_title' => 'Я использую метафорические методы в своей работе.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[13], 'client_title' => 'Мне комфортнее понимать поэтический язык, чем язык логики.', 'psychologist_title' => 'Я люблю использовать метафоры для выработки общего с клиентом языка при обсуждении проблемы.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[13], 'client_title' => 'Я предпочитаю, чтобы мой психолог называл все вещи своими именами.', 'psychologist_title' => 'Я думаю, что метафоры в процессе терапии только мешают и отвлекают клиента.', 'type' => 'many', 'psychologist_reverse' => true, 'client_reverse' => true],
            ['category_id' => $category[13], 'client_title' => 'Я с подозрением отношусь к методам психотерапии, в которых нужно представлять картинки в голове или придумывать ассоциации.', 'psychologist_title' => 'Чем точнее и ближе к реальности будет наша коммуникация с клиентом — тем эффективнее результат.', 'type' => 'many', 'psychologist_reverse' => true, 'client_reverse' => true],
            # Прямолинейность
            ['category_id' => $category[14], 'client_title' => 'Мне комфортно, когда специалист может высказываться по моему вопросу, при этом, не стараясь сгладить «острые углы».', 'psychologist_title' => 'Я предпочитаю говорить с клиентом прямо и открыто, ничего не утаивая и не сглаживая углов.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[14], 'client_title' => 'Мне нравится, когда разговор выстраивается четко и по делу.', 'psychologist_title' => 'Я считаю, что правильно говорить клиенту правду о его проблеме в лицо, показывая все так, как есть на самом деле.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[14], 'client_title' => 'Я предпочту услышать от специалиста честную точку зрения о моей проблеме, даже если она будет неприятной.', 'psychologist_title' => 'В своей работе я придерживаюсь правила «говорить по делу, без лишней воды».', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[14], 'client_title' => 'Я согласен с высказыванием: «Лучше горькая правда, чем сладкая ложь».', 'psychologist_title' => 'Я согласен с высказыванием: «Лучше горькая правда, чем сладкая ложь».', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            # Дипломатичность
            ['category_id' => $category[15], 'client_title' => 'Мне важно, чтобы психолог учитывал мое эмоциональное состояние и был аккуратен со мной.', 'psychologist_title' => 'В работе с клиентом необходимо быть деликатным, чтобы сохранить терапевтические отношения.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[15], 'client_title' => 'Считаю, что тактичность и деликатность — важные черты хорошего специалиста.', 'psychologist_title' => 'Считаю, что психологу во всех ситуациях необходимо быть с клиентом тактичным и осторожным в своих высказываниях.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[15], 'client_title' => 'Если между мной и психологом возникает открытый конфликт — это серьезный повод усомниться в его квалификации.', 'psychologist_title' => 'Я думаю, что конфронтация с клиентом неприемлема, хотя некоторые и думают, что она имеет терапевтический эффект.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[15], 'client_title' => 'Когда я вижу, что человек подбирает слова вместо того, чтобы сказать что-то прямо — это раздражает меня.', 'psychologist_title' => 'Я всегда взвешиваю свои слова, чтобы случайно не обидеть или задеть клиента.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => true],
            # Экспертная позиция
            ['category_id' => $category[16], 'client_title' => 'Признак хорошего специалиста — это умение дать объяснение на любой вопрос клиента.', 'psychologist_title' => 'Я считаю, что лучше дать ответ на вопрос клиента, даже если не уверен в нем, чем вовсе не ответить.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[16], 'client_title' => 'Психолог для меня — в первую очередь эксперт в своей теме, и я жду, что он сможет дать ответы на все мои вопросы.', 'psychologist_title' => 'Клиент приходит, чтобы получить помощь и ответы на свои вопросы, и чувствую, что должен их дать.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[16], 'client_title' => 'Меня раздражает, когда вместо прямого ответа собеседник пытается увести тему в сторону или спрашивает, что я сам об этом думаю.', 'psychologist_title' => 'Я не хочу, чтобы мой клиент смотрел на меня, как на эксперта, и ждал от меня ответов на все вопросы.', 'type' => 'many', 'psychologist_reverse' => true, 'client_reverse' => false],
            ['category_id' => $category[16], 'client_title' => 'Я спокойно отношусь к тому, что психолог может чего-то не знать или не быть уверенным в чем-то.', 'psychologist_title' => 'Я избегаю экспертной позиции в общении с клиентами.', 'type' => 'many', 'psychologist_reverse' => true, 'client_reverse' => true],
            # Авторитетная позиция
            ['category_id' => $category[17], 'client_title' => 'Я хочу, чтобы мой психолог являлся главной и движущей силой в нашей с ним работе.', 'psychologist_title' => 'Я являюсь движущей силой в работе с клиентом и определяю каждый шаг в нашей с ним деятельности.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[17], 'client_title' => 'Я хочу, чтобы мой психолог был для меня авторитетом.', 'psychologist_title' => 'Психолог должен быть авторитетом для клиента.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[17], 'client_title' => 'Я считаю, что психолог сам может выстроить процесс терапии, так как он лучше знает, что нужно мне, как клиенту.', 'psychologist_title' => 'Клиент приходит к психологу, потому что ищет того, на кого может опереться.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[17], 'client_title' => 'Я считаю, что от психолога зависит результат процесса терапии.', 'psychologist_title' => 'Я несу ответственность за процесс и результат взаимодействия с клиентом.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            # Позиция равного
            ['category_id' => $category[18], 'client_title' => 'Клиент вносит такой же вклад в процесс терапии, как и психолог.', 'psychologist_title' => 'Клиент вносит такой же вклад в процесс терапии, как и психолог.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[18], 'client_title' => 'Я считаю, что клиент и терапевт в равной степени ответственны за результат терапии.', 'psychologist_title' => 'Я считаю, что клиент и терапевт в равной степени ответственны за результат терапии.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[18], 'client_title' => 'Я хочу принимать активное участие в терапевтическом процессе, а не двигаться по готовому сценарию.', 'psychologist_title' => 'Для меня важно, чтобы мы с клиентом совместно выстраивали процесс нашей работы.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
            ['category_id' => $category[18], 'client_title' => 'Для меня важно обсуждать и формировать вместе с психологом дальнейший план нашей совместной работы.', 'psychologist_title' => 'Для меня важно получать обратную связь от клиента и вносить изменения в наш с ним процесс взаимодействия.', 'type' => 'many', 'psychologist_reverse' => false, 'client_reverse' => false],
        ]);

        Question::setEventDispatcher($dispatcher);
    }
}
