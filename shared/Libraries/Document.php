<?php

namespace Shared\Libraries;

class Document
{
    // Meta
    protected $title;
    protected $description;
    protected $keywords;
    protected $links = [];
    protected $styles = [];
    protected $scripts = [];
    /**
     *
     * @param   string  $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    /**
     *
     * @return  string
     */
    public function getTitle(): ?string
    {
        if (service('registry')->get('config_name')) {
            return $this->title . ' :: ' . service('registry')->get('config_name');
        } else {
            return $this->title;
        }
    }

    /**
     *
     * @param   string  $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     *
     * @param   string  $description
     *
     * @return  string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
    /**
     *
     * @param   string  $keywords
     */
    public function setKeywords(string $keywords): void
    {
        $this->keywords = $keywords;
    }
    /**
     *
     * @return  string
     */
    public function getKeywords(): ?string
    {
        return $this->keywords;
    }
    
    /**
     *
     * @param   string  $href
     * @param   string  $rel
     */
    public function addLink(string $href, string $rel): void
    {
        $this->links[$key] = [
            'href' => $href,
            'rel'  => $rel
        ];
    }
    /**
     *
     * @return  array
     */
    public function getLinks(): array
    {
        return esc($this->links, 'html');
    }
    /**
     *
     * @param   string  $href
     * @param   string  $rel
     * @param   string  $media
     */
    public function addStyle($href, $rel = 'stylesheet', $media = 'screen', $position = 'header'): void
    {
        $this->styles[$position][$href] = [
            'href'  => $href,
            'rel'   => $rel,
            'media' => $media
        ];
    }

    /**
     *
     * @return  array
     */
    public function getStyles(): array
    {
        return esc($this->styles, 'html');
    }
    /**
     *
     * @return  array
     */
    public function removeStyle($href): object
    {
        if (is_array($href)) {
            foreach ($href as $k) {
                $this->removeStyle($k);
            }
        }

        if ($href && array_key_exists($href, $this->styles)) {
            unset($this->styles[$href]);
        }
        return $this;
    }
    /**
     *
     *
     * @var   string  $src
     * @var   string  $position
     */
    public function addScript($src, $position = 'header'): void
    {
        $this->scripts[$position][$src] = $src;
    }
    /**
     *
     *
     * @param   string  $position
     *
     * @return  array
     */
    public function getScripts($position = 'header'): array
    {
        if (isset($this->scripts[$position])) {
            return esc($this->scripts[$position], 'html');
        } else {
            return [];
        }
    }
    

    // --------------------------------------------------------------------------------------------------
}
