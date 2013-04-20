<?php
class VF_LevelsTests_ConformTests_MMYTest extends Elite_Vaf_TestCase
{
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testConformsLevelMake()
    {
        $honda = new VF_Level( 'make' );
        $honda->setTitle('Honda');
        $honda->save();
        
        $honda2 = new VF_Level( 'make' );
        $honda2->setTitle('Honda');
        $honda2->save();
        
        $this->assertEquals( $honda->getId(), $honda2->getId(), 'when saving two makes with same title, they should get the same id' );
    }
    
    function testConformsLevelModel()
    {
        $honda = new VF_Level( 'make' );
        $honda->setTitle('Honda');
        $honda_make_id = $honda->save();
        
        $civic = new VF_Level( 'model' );
        $civic->setTitle('Civic');
        $civic->save( $honda_make_id );
            
        $civic2 = new VF_Level( 'model' );
        $civic2->setTitle('Civic');
        $civic2->save( $honda_make_id );
        
        $this->assertEquals( $civic->getId(), $civic2->getId(), 'when saving two models with the same titles & under the same make, they should get the same id' );
    }
    
    function testDoesntConformModelFromDiffrentMake()
    {
        $honda = new VF_Level( 'make' );
        $honda->setTitle('Honda');
        $honda_make_id = $honda->save();
        
        $civic = new VF_Level( 'model' );
        $civic->setTitle('Civic');
        $civic->save( $honda_make_id );
        
        $ford = new VF_Level( 'make' );
        $ford->setTitle('Ford');
        $ford_make_id = $ford->save();
            
        $civic2 = new VF_Level( 'model' );
        $civic2->setTitle('Civic');
        $civic2->save( $ford_make_id );
        
        $this->assertNotEquals( $civic->getId(), $civic2->getId(), 'when saving two models with same title, but under different makes, they should get different ids' );
    }
    
          
}
