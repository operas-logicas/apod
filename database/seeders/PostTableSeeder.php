<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception;
use Illuminate\Database\Seeder;

function runIfRequestFails() {
    $post = new Post([
        'date' => date('Y-m-d', time() - (86400 * 2)),
        'img_url' => 'https://apod.nasa.gov/apod/image/2101/NGC1316Center_HubbleNobre_960.jpg',
        'title' => 'Central NGC 1316: After Galaxies Collide',
        'copyright' => null,
        'original_date' => '2021-01-26',
        'explanation' => "How did this strange-looking galaxy form?  Astronomers turn detectives when trying to figure out the cause of unusual jumbles of stars, gas, and dust like NGC 1316. Inspection indicates that NGC 1316 is an enormous elliptical galaxy that somehow includes dark dust lanes usually found in a spiral galaxy.  Detailed images taken by the Hubble Space Telescope shows details, however, that help in reconstructing the history of this gigantic tangle.  Deep and wide images show huge collisional shells, while deep central images reveal fewer globular clusters of stars toward NGC 1316's interior.  Such effects are expected in galaxies that have undergone collisions or merging with other galaxies in the past few billion years.  The dark knots and lanes of dust, prominent in the featured image, indicate that one or more of the devoured galaxies were spiral galaxies.  NGC 1316 spans about 50,000 light years and lies about 60 million light years away toward the constellation of the Furnace (Fornax).",
        'active' => true,
        'user_id' => 1
    ]);
    $post->save();

    $post = new Post([
        'date' => date('Y-m-d', time() - 86400),
        'img_url' => 'https://apod.nasa.gov/apod/image/2101/NGC5775_NraoEnglish_1080.jpg',
        'title' => 'The Vertical Magnetic Field of NGC 5775',
        'copyright' => null,
        'original_date' => '2021-01-27',
        'explanation' => "How far do magnetic fields extend up and out of spiral galaxies?  For decades astronomers knew only that some spiral galaxies had magnetic fields.  However, after NRAO's Very Large Array (VLA) radio telescope (popularized in the movie Contact) was upgraded in 2011, it was unexpectedly discovered that these fields could extend vertically away from the disk by several thousand light-years.  The featured image of edge-on spiral galaxy NGC 5775, observed in the CHANG-ES (Continuum Halos in Nearby Galaxies) survey, also reveals spurs of magnetic field lines that may be common in spirals.  Analogous to iron filings around a bar magnet, radiation from electrons trace galactic magnetic field lines by spiraling around these lines at almost the speed of light.  The filaments in this image are constructed from those tracks in VLA data.  The visible light image, constructed from Hubble Space Telescope data, shows pink gaseous regions where stars are born.  It seems that winds from these regions help form the magnificently extended galactic magnetic fields.",
        'active' => true,
        'user_id' => 1
    ]);
    $post->save();

    $post = new Post([
        'date' => date('Y-m-d'),
        'img_url' => 'https://apod.nasa.gov/apod/image/2101/M66_Hubble_LeoShatz_Crop1024.jpg',
        'title' => 'Messier 66 Close Up',
        'copyright' => null,
        'original_date' => '2021-01-28',
        'explanation' => "Big, beautiful spiral galaxy Messier 66 lies a mere 35 million light-years away. The gorgeous island universe is about 100 thousand light-years across, similar in size to the Milky Way. This reprocessed Hubble Space Telescope close-up view spans a region about 30,000 light-years wide around the galactic core. It shows the galaxy's disk dramatically inclined to our line-of-sight. Surrounding its bright core, the likely home of a supermassive black hole, obscuring dust lanes and young, blue star clusters sweep along spiral arms dotted with the tell-tale glow of pinksh star forming regions. Messier 66, also known as NGC 3627, is the brightest of the three galaxies in the gravitationaly interacting Leo Triplet.",
        'active' => true,
        'user_id' => 1
    ]);
    $post->save();
}

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Use Guzzle to get some sample data from NASA's APOD API
         */
        $client = new Client();

        try {
            $response = $client->request(
                'GET',
                'https://api.nasa.gov/planetary/apod?thumbs=true&count=20&api_key=DEMO_KEY'
            );

            if (in_array('application/json', $response->getHeader('Content-Type'))) {
                $json = json_decode($response->getBody());

                $users = User::all();
                $user_ids = [];

                foreach ($users as $user) {
                    $user_ids[] = $user->id;
                }

                foreach ($json as $record) {
                    $post = new Post([
                        'date' => date('Y-m-d', rand(time() - 60*60*24*3, time())),
                        'img_url' => $record->thumbnail_url ?? $record->url,
                        'title' => $record->title,
                        'copyright' => $record->copyright ?? null,
                        'original_date' => $record->date,
                        'explanation' => $record->explanation,
                        'active' => true,
                        'user_id' => $user_ids[array_rand($user_ids)]
                    ]);

                    $post->save();
                }

            } else {
                runIfRequestFails();
            }

        } catch (Exception\ConnectException $e) {
            runIfRequestFails();
        } catch (Exception\RequestException $e) {
            runIfRequestFails();
        }
    }
}
