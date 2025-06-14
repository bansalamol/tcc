<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SearchForm extends Component
{
    public string $query = '';
    public string $routeName = '';
    public string $queryParam = 'q';

    public function mount(string $routeName, string $queryParam = 'q')
    {
        $this->routeName = $routeName;
        $this->queryParam = $queryParam;
        $this->query = request()->query($this->queryParam, '');
    }

    public function search()
    {
        return redirect()->route($this->routeName, [$this->queryParam => $this->query]);
    }

    public function resetSearch()
    {
        $this->query = '';
        return redirect()->route($this->routeName);
    }

    public function render()
    {
        return view('livewire.search-form');
    }
}

