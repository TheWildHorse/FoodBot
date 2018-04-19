<?php


namespace App\Services\NLP;


use App\Entity\WordVariations;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class KeywordProcessingService
 * @package App\Services\NLP
 */
class KeywordProcessingService
{

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * KeywordProcessingService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * Returns stemmed keywords for text.
     * @param string $text
     * @return array
     */
    public function getKeywordsFromText($text): array
    {
        $words = explode(' ', $text);
        $words = $this->removeStopwords($words);
        $words = $this->stemWords($words);

        return $words;
    }

    /**
     * @param array $words
     * @return array
     */
    protected function removeStopwords(array $words): array
    {
        $stopwords = ["a","ako","ali","bi","bih","bila","bili","bilo","bio","bismo","biste","biti","bumo","da","do","duž","ga","hoće","hoćemo","hoćete","hoćeš","hoću","i","iako","ih","ili","iz","ja","je","jedna","jedne","jedno","jer","jesam","jesi","jesmo","jest","jeste","jesu","jim","joj","još","ju","kada","kako","kao","koja","koje","koji","kojima","koju","kroz","li","me","mene","meni","mi","mimo","moj","moja","moje","mu","na","nad","nakon","nam","nama","nas","naš","naša","naše","našeg","ne","nego","neka","neki","nekog","neku","nema","netko","neće","nećemo","nećete","nećeš","neću","nešto","ni","nije","nikoga","nikoje","nikoju","nisam","nisi","nismo","niste","nisu","njega","njegov","njegova","njegovo","njemu","njezin","njezina","njezino","njih","njihov","njihova","njihovo","njim","njima","njoj","nju","no","o","od","odmah","on","ona","oni","ono","ova","pa","pak","po","pod","pored","prije","s","sa","sam","samo","se","sebe","sebi","si","smo","ste","su","sve","svi","svog","svoj","svoja","svoje","svom","ta","tada","taj","tako","te","tebe","tebi","ti","to","toj","tome","tu","tvoj","tvoja","tvoje","u","uz","vam","vama","vas","vaš","vaša","vaše","već","vi","vrlo","za","zar","će","ćemo","ćete","ćeš","ću","što"];

        return array_diff($words, $stopwords);
    }

    /**
     * @param array $words
     * @return array
     */
    protected function stemWords(array $words): array
    {
        $wv = $this->em->getRepository('App:WordVariations');

        $result = [];
        foreach ($words as $word) {
            /** @var WordVariations $resultObject */
            $resultObject = $wv->findOneBy(['variation' => $word]);
            if($result === null) {
                $result[] = $resultObject->getWord();
            }
            else {
                $result[] = $word;
            }
        }

        return $result;
    }

}