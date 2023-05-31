<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateResources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:resources';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('https://swapi.dev/api/');

        $jsonData = $response->json();

        if (!File::exists(public_path()."/files")) {
            File::makeDirectory(public_path() . "/files");
        }

        var_dump( Http::get('https://swapi.dev/api/films/schema/')->json() );die;

        foreach($jsonData as $resource_name => $resource_url) {
            $this->save_resource($resource_name,$resource_url);
            // echo "$resource_name = $resource_url<br>";
          }

        // var_dump($jsonData);
    }

    private function save_resource($resource_name,$resource_url) {
        switch ($resource_name) {
            case "films":
                $this->save_films($resource_url);
                break;
            case "people":
                $this->save_people($resource_url);
                break;
            case "planets":
                $this->save_planets($resource_url);
                break;
            case "species":
                $this->save_species($resource_url);
                break;
            case "starships":
                $this->save_starships($resource_url);
                break;
            case "vehicles":
                $this->save_vehicles($resource_url);
                break;
            default:
          }
    }

    private function save_films($resource_url) {
        $this->info('Films csv file create start...');
        $filename = public_path("files/films.csv");
        $file = fopen($filename, 'w');

        $response = Http::get($resource_url);
        $jsonData = $response->json();

        $columns = array('title', 'episode_id', 'opening_crawl', 'director', 'producer', 'release_date', 'species', 'starships', 'vehicles', 'characters', 'planets', 'url', 'created', 'edited');
        $results = $this->get_all_results($jsonData,array());
        $results_count = count($results);

        fputcsv($file, $columns);
        $i=0;

        foreach ($results as $result) {
            $row['title']  = $result['title'];
            $row['episode_id']    = $result['episode_id'];
            $row['opening_crawl']    = $result['opening_crawl'];
            $row['director']  = $result['director'];
            $row['producer']  = $result['producer'];
            $row['release_date']  = $result['release_date'];
            $row['species']  = $this->get_links_results($result['species']);
            $row['starships']  = $this->get_links_results($result['starships']);
            $row['vehicles']  = $this->get_links_results($result['vehicles']);
            $row['characters']  = $this->get_links_results($result['characters']);
            $row['planets']  = $this->get_links_results($result['planets']);
            $row['url']  = $result['url'];
            $row['created']  = $result['created'];
            $row['edited']  = $result['edited'];

            fputcsv($file, $row);
            $i++;
            $this->info('Film '.$i.'/'.$results_count.' saved.');
        }
        fclose($file);
        $this->info('Films csv file created done!');
    }

    private function save_people($resource_url) {
        $this->info('People csv file create start...');
        $filename = public_path("files/people.csv");
        $file = fopen($filename, 'w');

        $response = Http::get($resource_url);
        $jsonData = $response->json();

        $columns = array('name', 'birth_year', 'eye_color', 'gender', 'hair_color', 'height', 'mass', 'skin_color', 'homeworld', 'films', 'species', 'starships', 'vehicles', 'url', 'created', 'edited');
        $results = $this->get_all_results($jsonData,array());
        $results_count = count($results);

        fputcsv($file, $columns);
        $i=0;

        foreach ($results as $result) {
            $row['name']  = $result['name'];
            $row['birth_year']    = $result['birth_year'];
            $row['eye_color']    = $result['eye_color'];
            $row['gender']  = $result['gender'];
            $row['hair_color']  = $result['hair_color'];
            $row['height']  = $result['height'];
            $row['mass']  = $result['mass'];
            $row['skin_color']  = $result['skin_color'];
            $row['homeworld']  = $result['homeworld'];
            $row['films']  = $this->get_links_results($result['films']);
            $row['species']  = $this->get_links_results($result['species']);
            $row['starships']  = $this->get_links_results($result['starships']);
            $row['vehicles']  = $this->get_links_results($result['vehicles']);
            $row['url']  = $result['url'];
            $row['created']  = $result['created'];
            $row['edited']  = $result['edited'];

            fputcsv($file, $row);
            $i++;
            $this->info('People '.$i.'/'.$results_count.' saved.');
        }

        fclose($file);
        $this->info('People csv file created done!');

    }

    private function save_planets($resource_url) {
        $this->info('Planets csv file create start...');
        $filename = public_path("files/planets.csv");
        $file = fopen($filename, 'w');

        $response = Http::get($resource_url);
        $jsonData = $response->json();

        $columns = array('name', 'diameter', 'rotation_period', 'orbital_period', 'gravity', 'population', 'climate', 'terrain', 'surface_water', 'residents', 'films', 'url', 'created', 'edited');
        $results = $this->get_all_results($jsonData,array());
        $results_count = count($results);

        fputcsv($file, $columns);
        $i=0;

        foreach ($results as $result) {
            $row['name']  = $result['name'];
            $row['diameter']    = $result['diameter'];
            $row['rotation_period']    = $result['rotation_period'];
            $row['orbital_period']  = $result['orbital_period'];
            $row['gravity']  = $result['gravity'];
            $row['population']  = $result['population'];
            $row['climate']  = $result['climate'];
            $row['terrain']  = $result['terrain'];
            $row['surface_water']  = $result['surface_water'];
            $row['residents']  = $this->get_links_results($result['residents']);
            $row['films']  = $this->get_links_results($result['films']);
            $row['url']  = $result['url'];
            $row['created']  = $result['created'];
            $row['edited']  = $result['edited'];

            fputcsv($file, $row);
            $i++;
            $this->info('Planet '.$i.'/'.$results_count.' saved.');
        }
        fclose($file);
        $this->info('Planets csv file created done!');
    }

    private function save_species($resource_url) {
        $this->info('Species csv file create start...');
        $filename = public_path("files/species.csv");
        $file = fopen($filename, 'w');

        $response = Http::get($resource_url);
        $jsonData = $response->json();

        $columns = array('name', 'classification', 'designation', 'average_height', 'average_lifespan', 'eye_colors', 'hair_colors', 'skin_colors', 'language', 'homeworld', 'people', 'films', 'url', 'created', 'edited');
        $results = $this->get_all_results($jsonData,array());
        $results_count = count($results);

        fputcsv($file, $columns);
        $i=0;

        foreach ($results as $result) {
            $row['name']  = $result['name'];
            $row['classification']    = $result['classification'];
            $row['designation']    = $result['designation'];
            $row['average_height']  = $result['average_height'];
            $row['average_lifespan']  = $result['average_lifespan'];
            $row['eye_colors']  = $result['eye_colors'];
            $row['hair_colors']  = $result['hair_colors'];
            $row['skin_colors']  = $result['skin_colors'];
            $row['language']  = $result['language'];
            $row['homeworld']  = $result['homeworld'];
            $row['people']  = $this->get_links_results($result['people']);
            $row['films']  = $this->get_links_results($result['films']);
            $row['url']  = $result['url'];
            $row['created']  = $result['created'];
            $row['edited']  = $result['edited'];

            fputcsv($file, $row);
            $i++;
            $this->info('Specie '.$i.'/'.$results_count.' saved.');
        }
        fclose($file);
        $this->info('Species csv file created done!');
    }

    private function save_starships($resource_url) {
        $this->info('Starships csv file create start...');
        $filename = public_path("files/starships.csv");
        $file = fopen($filename, 'w');

        $response = Http::get($resource_url);
        $jsonData = $response->json();

        $columns = array('name', 'model', 'starship_class', 'manufacturer', 'cost_in_credits', 'length', 'crew', 'passengers', 'max_atmosphering_speed', 'hyperdrive_rating', 'MGLT', 'cargo_capacity', 'consumables,', 'films', 'pilots', 'url', 'created', 'edited');
        $results = $this->get_all_results($jsonData,array());
        $results_count = count($results);

        fputcsv($file, $columns);
        $i=0;

        foreach ($results as $result) {
            $row['name']  = $result['name'];
            $row['model']    = $result['model'];
            $row['starship_class']    = $result['starship_class'];
            $row['manufacturer']  = $result['manufacturer'];
            $row['cost_in_credits']  = $result['cost_in_credits'];
            $row['length']  = $result['length'];
            $row['crew']  = $result['crew'];
            $row['passengers']  = $result['passengers'];
            $row['max_atmosphering_speed']  = $result['max_atmosphering_speed'];
            $row['hyperdrive_rating']  = $result['hyperdrive_rating'];
            $row['MGLT']  = $result['MGLT'];
            $row['cargo_capacity']  = $result['cargo_capacity'];
            $row['consumables']  = $result['consumables'];
            $row['films']  = $this->get_links_results($result['films']);
            $row['pilots']  = $this->get_links_results($result['pilots']);
            $row['url']  = $result['url'];
            $row['created']  = $result['created'];
            $row['edited']  = $result['edited'];

            fputcsv($file, $row);
            $i++;
            $this->info('Starship '.$i.'/'.$results_count.' saved.');
        }
        fclose($file);
        $this->info('Starships csv file created done!');

    }

    private function save_vehicles($resource_url) {
        $this->info('Vehicles csv file create start...');
        $filename = public_path("files/vehicles.csv");
        $file = fopen($filename, 'w');

        $response = Http::get($resource_url);
        $jsonData = $response->json();

        $columns = array('name', 'model', 'vehicle_class', 'manufacturer', 'length', 'cost_in_credits', 'crew', 'passengers', 'max_atmosphering_speed', 'cargo_capacity', 'consumables,', 'films', 'pilots', 'url', 'created', 'edited');
        $results = $this->get_all_results($jsonData,array());
        $results_count = count($results);

        fputcsv($file, $columns);
        $i=0;

        foreach ($results as $result) {
            $row['name']  = $result['name'];
            $row['model']    = $result['model'];
            $row['vehicle_class']    = $result['vehicle_class'];
            $row['manufacturer']  = $result['manufacturer'];
            $row['length']  = $result['length'];
            $row['cost_in_credits']  = $result['cost_in_credits'];
            $row['crew']  = $result['crew'];
            $row['passengers']  = $result['passengers'];
            $row['max_atmosphering_speed']  = $result['max_atmosphering_speed'];
            $row['cargo_capacity']  = $result['cargo_capacity'];
            $row['consumables']  = $result['consumables'];
            $row['films']  = $this->get_links_results($result['films']);
            $row['pilots']  = $this->get_links_results($result['pilots']);
            $row['created']  = $result['created'];
            $row['edited']  = $result['edited'];

            fputcsv($file, $row);
            $i++;
            $this->info('Vehicle '.$i.'/'.$results_count.' saved.');
        }
        fclose($file);
        $this->info('Vehicles csv file created done!');
    }

    private function get_all_results($json,$total_results) {
        $add_to_total_results = array();
        if(!is_array($json)) {
            return;
        } else {
            if($json['next']) {
                $response = Http::get($json['next']);
                $jsonData = $response->json();
                $add_to_total_results = $this->get_all_results($jsonData,$total_results);
            }
        }

        $total_results = array_merge($json['results'],$add_to_total_results);

        return $total_results;
    }

    private function get_links_results($arrays) {
        $return = array();
        foreach($arrays as $array) {
            $return[] = Http::get($array)->json();
        }
        return json_encode($return);
    }
}
