<?php

namespace Customize\Form\Type;

use Eccube\Entity\BaseInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;

class BaseInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // フォームビルダーでフォームフィールドを追加
        $builder->add('company_name_vn', TextType::class, [
            'label' => '会社名(VN)',
            'required' => true
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // data_classでバインドするエンティティを指定
        $resolver->setDefaults([
            'data_class' => BaseInfo::class // ここでBaseInfoをバインド
        ]);
    }
}
