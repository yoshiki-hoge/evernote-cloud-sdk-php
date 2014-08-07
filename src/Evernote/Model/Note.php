<?php

namespace Evernote\Model;

use EDAM\Limits\Constant;
use Evernote\Helper\EnmlConverterInterface;

class Note
{
    /** @var \EDAM\Types\Note  */
    protected $edamNote;

    /** @var string */
    protected $guid;

    /** @var string  */
    protected $title = '';

    /** @var \Evernote\Model\NoteContentInterface */
    protected $content = '';

    /** @var array */
    protected $resources = array();

    public function __construct(\EDAM\Types\Note $edamNote = null)
    {
        if (null !== $edamNote) {
            $this->edamNote  = $edamNote;
            $this->guid      = $edamNote->guid;
            $this->title     = $edamNote->title;
            $this->content   = $edamNote->content;
            $this->resources = $edamNote->resources;
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . ucfirst($name);

        if (property_exists($this, $name) && method_exists($this, $method)) {

            return $this->$method($value);
        }
    }

    public function __get($name)
    {
        $method = 'get' . ucfirst($name);

        if (property_exists($this, $name) && method_exists($this, $method)) {

            return $this->$method();
        }
    }

    public function setContent(NoteContentInterface $content)
    {
        $this->content = $content->toEnml();

        return $this;
    }

    public function validateForLimits()
    {
        $contentLength = strlen($this->getContent());
        if ($contentLength > Constant::get('EDAM_NOTE_CONTENT_LEN_MAX')
            || $contentLength < Constant::get('EDAM_NOTE_CONTENT_LEN_MIN')) {
            return false;
        }

        return true;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return \Evernote\Model\NoteContentInterface
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return \EDAM\Types\Note
     */
    public function getEdamNote()
    {
        return $this->edamNote;
    }

    /**
     * @return string
     */
    public function getGuid()
    {
        return $this->guid;
    }





}