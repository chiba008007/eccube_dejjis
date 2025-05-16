<?php

namespace Customize\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Customize\Entity\Hello;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class HelloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'お名前',
                'attr' => [
                    'required' => true,
                    'placeholder' => 'Enter your name',
                    'class' => 'form-control'
                ]
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'コメント',
                'attr' => [
                    'placeholder' => 'Enter your comment',
                    'class' => 'form-control'
                ]
            ])
            ->add('startDate', DateType::class, [
                'widget' => 'single_text', // input type=dateにする
                'label' => '開始日',
                'required' => false
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text', // input type=dateにする
                'label' => '終了日',
                'required' => false
            ])
            ->add('image', FileType::class, [
                'label' => '画像アップロード',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => '有効な画像ファイルを選んでください'
                    ])
                ]
            ]);

    }

    // フォーム全体の基本設定を指定
    public function configureOptions(OptionsResolver $resolver): void
    {
        // このフォームはHelloエンティティと関連付けられていることを指定
        // これにより、SymfonyはフォームのデータをHelloエンティティにマッピングします
        // Helloクラスのインスタンスに対して自動で値をセットしてくれる
        $resolver->setDefaults([
            'data_class' => Hello::class,
        ]);
    }
}
