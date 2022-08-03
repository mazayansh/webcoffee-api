<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'BALI BLUE MOON SINGLE ORIGIN DARK ROAST COFFEE',
                'slug' => 'bali-blue-moon-single-origin-dark-roast-coffee',
                'roast_id' => 3,
                'type_id' => 8,
                'description' => '<b>Profile</b>: Fragrant toffee aroma with flavors of walnuts and semi-sweet chocolate and a crisp black cherry finish.<br>
                <b>Place: Kintamani Highlands, North Bali, Indonesia. This coffee is grown at an altitude between 3,200 and 3,900 feet, under shade trees, with orange and tangerine trees planted<br>
                <b>People</b>: Arabica coffee farmers in Kintamani are organized into traditional groups called Subak Abian. The groups act as rural cooperatives, which sell coffee in concert with export groups, and are founded on the Hindu philosophy of "Tri Hita Karana" (The Happiness Causes). This philosophy consists of the importance of the relationship of human beings to God, to other humans and to the environment.<br>
                <b>Process</b>: The coffee is organically farmed, although not certified. Harvesting is done from May to October and only ripe fruit is picked. The coffee must contain 95% red fruit to be accepted for processing. The coffee is semi-washed, with a two-step sun drying process.<br>
                <b>Pairing</b>: Chocolate brownies and bagels.',
                'aftertaste' => 'walnuts and semi-sweet chocolate, with a crisp black cherry finish.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'BRAZIL CERRADO DARK GROUND SINGLE ORIGIN COFFEE',
                'slug' => 'brazil-cerrado-dark-ground-single-origin-coffee',
                'roast_id' => 3,
                'type' => 8,
                'description' => '<b>Profile</b>: Dark Roast full-bodied with a bold aroma, earthy flavor & bittersweet finish.<br>
                <b>Place</b>: Cerrado region of Brazil (Single origin)',
                'aftertaste' => 'earthy flavor and bittersweet finish',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'DECAF ESPRESSO ROAST COFFEE',
                'slug' => 'decaf-esspresso-roast-coffee',
                'roast_id' => 3,
                'type' => 1,
                'description' => '<b>Profile</b>: Velvety body with caramel like aroma, earthy flavor and a bittersweet finish without the caffeine. This blend captures a full range of origin characteristics from crisp and bright to syrupy, earthy and full bodied. The range of roast degrees lends more complexity and versatility.<br>
                <b>Place</b>: Costa Rica, Guatemala, Papua New Guinea, Sumatra<br>
                <b>People</b>: Our experienced roasters prepare this decaf blend to work well as a drip coffee and provide a balanced profile that lends well to lattes, cappuccinos, or as a straight shot.<br>
                <b>Process</b>: Each origin coffee is carefully roasted individually to its optimum level and then combined in the right proportion to create the final blend. There are a total of four coffees, one roasted at two levels, resulting in five individual blend components.<br>
                <b>Pairing</b>: Caramel, dark chocolate, chocolate cake, rum cake.',
                'aftertaste' => 'earthy flavor and a bittersweet',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'BRAZIL CERRADO LIGHT ROAST SINGLE ORIGIN COFFEE',
                'slug' => 'brazil-cerrado-light-roast-single-origin-coffee',
                'roast_id' => 1,
                'type' => 8,
                'description' => '<b>Profile</b>: Soft bodied with earthy flavor and subtle walnut notes.<br>
                <b>Place</b>: Cerrado region, Brazil.<br>
                <b>People</b>: Brazil is the largest producer of coffee in the world. The Cerrado region is well known for its uniquely processed coffee.<br>
                <b>Process</b>: Natural dry-processed coffee uses a unique method which requires the trees to be nourished by water beyond the ripeness of the cherries. This process requires twice as much time because the fruit has to ripen, darken and dry on the branch. This is by far one of the most unique and elaborate ways to process coffee, offering a nicely fruity and bright aftertaste.<br>
                <b>Pairing</b>: Fresh bananas, dates, banana nut muffin, carrot cake.',
                'aftertaste' => 'Soft bodied with earthy flavor and subtle walnut notes',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'COSTA RICA LA MINITA SINGLE ORIGIN RESERVE COFFEE',
                'slug' => 'costa-rica-la-minita-single-origin-reserve-coffee',
                'roast_id' => 1,
                'type' => 6,
                'description' => '<b>Profile</b>: Rich & Smooth<br>
                <b>People</b>: Founder Bill McAlpin created a self-contained, family community for his workers that are also integrated into the nearby town of Bustamante. The full-time workers and their families all live on the farm grounds, and are provided free housing, utilities, clean water, and preventative medical and dental care. In addition, La Minita also sponsors a soccer team and a choir. A cooperative food program is also set up through the worker\'s association to assist in managing food costs and allowing workers to take advantage of bulk purchasing.<br>
                <b>Process</b>: Coffee fruit is meticulously hand-selected by contract workers brought to the farm each year and supervised by farm employees. The workers only pick perfectly ripe fruit and are inspected to ensure the quality of their work. They are paid a premium for their skill and respect of farm property. At the mill, the La Minita is pulped, fermented, fully washed, machine dried, and meticulously sorted by hand to remove every imperfect bean. We roast this coffee to a light/medium color to highlight the subtle character.<br>
                <b>Pairings</b>: Walnut coffee cake, pears. Try it with our Carrot Walnut Loaf!',
                'aftertaste' => 'Rich & Smooth',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'JAMAICA BLUE MOUNTAIN SINGLE ORIGIN RESERVE COFFEE 100%',
                'slug' => 'jamaica-blue-mountain-single-origin-reserve-coffee',
                'roast_id' => 1,
                'type' => 6,
                'description' => '<b>Place</b>: Our Jamaica Blue Mountain coffee is grown at the Mavis Bank Estate \- one of four certified coffee producers of Jamaica Blue Mountain coffee. Established in 1885, this estate utilizes only spring water to sort the green beans, which are then \'put to sleep\' for 3-4 months at 3000 feet where the coffee begins to develop, becoming a greenish blue color. The coffee trees are located on the East & West sides of the mountain so that they receive only 4-5 hours of direct sunlight per day. Hence the beans mature at a much slower rate (taking 7-8 months, rather than the usual 4-5).<br>
                <b>Profile</b>: Light & Subtle<br>
                <b>People</b>: Established in the 1930\'s by Victor Munn, Mavis Bank was rebuilt by his nephew Keble Munn in the late 1950\'s. The Munn family still presides over the operations today, processing fruit from the original property along with fruit delivered by thousands of nearby farmers. The harvest period extends from December to May. Each tree produces only about 7 pounds of coffee annually.<br>
                <b>Process</b>: Due to the restricted area qualified to grow this exceptional coffee, only 4000 barrels (650,000 pounds) are produced per year. The beans are handpicked, and very limited amounts of machinery can be employed in its\' processing. Most production is by hand.<br>
                <b>Pairings</b>: Fresh peaches or strawberries. ',
                'aftertaste' => 'Light & Subtle',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'COLD BREW COARSE GROUND COFFEE BLEND WITH CHICORY',
                'slug' => 'cold-brew-coarse-ground-coffee-blend-with-chicory',
                'roast_id' => 2,
                'type' => 2,
                'description' => 'Cold Brew Ground Coffee with chicory from The Coffee Bean & Tea Leaf was made for (you guessed it) cold brewing. This is the same product we use in our cafes for our popular cold brew coffee drinks. This product is a coarse ground coffee which is the recommended grind for cold brew coffee. We combine some of the finest Arabica coffee in the world including our light roast coffee beans from Ethiopia and our Blue Moon dark roast beans from Indonesia to create this tantalizing medium roast coffee blend. By adding a touch of chicory root, this ground craft coffee product has a slightly sweet toffee aroma with fruit and walnut notes and offers a spicy smooth finish. Chicory got its start with coffee blends in France adding a subtle culinary twist on coffee and also became popular with coffee blends in New Orleans. Try some NOLA chicory cold brew ground coffee today!',
                'aftertaste' => 'fruit and walnut notes and offers a spicy smooth finish',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'COOKIE BUTTER MEDIUM ROAST GROUND COFFEE - LIMITED EDITION',
                'slug' => 'cookie-butter-medium-roast-ground-coffee-limited-edition',
                'roast_id' => 2,
                'type' => 2,
                'description' => 'Cookie Butter Coffee is a retuning holiday favorite. This seasonal ground coffee has cinnamon and creamy cookie butter notes with a snappy ginger finish. Cookie Butter Coffee is a medium roast flavored with the season\'s insprired cinnamon and spices. This product comes in a gift-worthy beautiful 16oz package.<br>
                Our flavored coffees feature the highest quality and most delicious coffee flavors available applied to a base of 100% Arabica, Specialty Grade Colombia coffee. Unlike many coffee companies, we only flavor our coffee after grinding, for better flavor delivery and to avoid losing the fragile aromatics during the grinding process.',
                'aftertaste' => 'cinnamon and creamy cookie butter notes with a snappy ginger finish',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'HAZELNUT COFFEE',
                'slug' => 'hazelnut-coffee',
                'roast_id' => 2,
                'type' => 2,
                'description' => 'Hazelnut flavored ground coffee by The Coffee Bean & Tea Leaf is an earthy, full-bodied blend that lets the intense aroma of roasted hazelnuts shine.',
                'aftertaste' => 'hazelnut',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // [
            //     'name' => '',
            //     'roast_id' => '',
            //     'type' => '',
            //     'description' => '',
            //     'aftertaste' => ''
            // ]
        ]);
    }
}
